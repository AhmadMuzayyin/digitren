<?php

namespace App\Http\Controllers\Tabungan;

use App\Exports\TabunganExport;
use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\Tabungan;
use App\Models\TransaksiTabungan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Toastr;
use Yajra\DataTables\Facades\DataTables;

class SaldoDebitController extends Controller
{
    public function index()
    {
        $santri = Santri::all();
        if (request()->ajax()) {
            $tabungan = Tabungan::with('santri')->get();
            return DataTables::of($tabungan)
                ->addIndexColumn()
                ->addColumn('action', 'pages.saldo_debit.include.action')
                ->addcolumn('nama', function ($tabungan) {
                    return $tabungan->santri->user->name;
                })
                ->addcolumn('no_induk', function ($tabungan) {
                    return $tabungan->santri->no_induk;
                })
                ->toJson();
        }
        return view('pages.saldo_debit.index');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'santri_id' => 'required',
            'saldo' => 'required|numeric',
            'keterangan' => 'nullable',
        ]);
        try {
            if ($request->santri_id == 'semua') {
                $santri_tabungan = Tabungan::get()->pluck('santri_id')->toArray();
                if (count($santri_tabungan) > 0) {
                    Toastr::info('Tidak dapat menambah semua santri');

                    return redirect()->back();
                } else {
                    $santri = Santri::where('status', 'Santri Aktif')->get();
                    if (count($santri) > 0) {
                        foreach ($santri as $key => $value) {
                            $tabungan = Tabungan::create([
                                'santri_id' => $value->id,
                                'saldo' => 0,
                                'keterangan' => null,
                            ]);
                            if ($tabungan->saldo > 0) {
                                TransaksiTabungan::create([
                                    'santri_id' => $tabungan->santri_id,
                                    'tanggal_transaksi' => date('Y-m-d'),
                                    'jenis_transaksi' => 'Setoran',
                                    'jumlah_transaksi' => $tabungan->saldo,
                                    'saldo_saatini' => $tabungan->saldo,
                                ]);
                            }
                        }
                        Toastr::success('Berhasil menambahkan semua santri');

                        return redirect()->back();
                    } else {
                        Toastr::info('Tidak ada santri yang dapat ditambahkan');

                        return redirect()->back();
                    }
                }
            }
            if (Tabungan::firstWhere('santri_id', $validate['santri_id'])) {
                Toastr::info('Santri sudah memiliki tabungan');
            } else {
                if (Santri::firstWhere('id', $validate['santri_id'])->status == 'Santri Alumni') {
                    Toastr::info('Santri sudah menjadi alumni');
                } else {
                    $tabungan = Tabungan::create($validate);
                    if ($tabungan->saldo > 0) {
                        TransaksiTabungan::create([
                            'santri_id' => $tabungan->santri_id,
                            'tanggal_transaksi' => date('Y-m-d'),
                            'jenis_transaksi' => 'Setoran',
                            'jumlah_transaksi' => $tabungan->saldo,
                            'saldo_saatini' => $tabungan->saldo,
                        ]);
                    }
                    Toastr::success('Berhasil menyimpan data');
                }
            }

            return redirect()->back();
        } catch (\Throwable $th) {
            //dd($th->getMessage());
            Toastr::error('Gagal menyimpan data');

            return redirect()->back();
        }
    }

    public function export($id)
    {
        $santri = Santri::with('user')->where('id', $id)->first();
        $filname = $santri->user->name . ' - ' . $santri->desa;

        $tabungan = TransaksiTabungan::with('santri')->where('santri_id', $id)->get();

        return Excel::download(new TabunganExport($tabungan), $filname . '_Tabungan.xlsx');

        return redirect()->back();
    }

    public function show($id)
    {
        $data = TransaksiTabungan::where('santri_id', $id)->get();

        return view('pages.saldo_debit.history', compact('data'));
    }

    public function destroy(Tabungan $tabungan)
    {
        try {
            $tabungan->delete();
            TransaksiTabungan::where('santri_id', $tabungan->santri_id)->delete();
            Toastr::success('Berhasil menghapus data');

            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Gagal menghapus data');

            return redirect()->back();
        }
    }
}
