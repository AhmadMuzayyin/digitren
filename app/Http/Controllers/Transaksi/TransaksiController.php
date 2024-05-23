<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\Tabungan;
use App\Models\TransaksiTabungan;
use Illuminate\Http\Request;
use Toastr;

class TransaksiController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $noinduk = request()->get('no_induk');
            $santri = Tabungan::with('santri', 'santri.user')->whereHas('santri', function ($query) use ($noinduk) {
                $query->where('no_induk', $noinduk);
            })->first();
            if ($santri) {
                $saldo = Tabungan::whereHas('santri', function ($query) use ($noinduk) {
                    $query->where('no_induk', $noinduk);
                })->sum('saldo');
                if (request()->get('jenis') == 'Penarikan') {
                    $tr = TransaksiTabungan::where('santri_id', $santri->santri->id)->whereDate('tanggal_transaksi', now()->toDateString())->where('jenis_transaksi', 'Penarikan')->get();
                    if (!$tr->isEmpty()) {
                        return response()->json(['message' => "Santri dengan nomor induk <strong> $noinduk </strong> telah melakukan penarikan"], 200);
                    } else {
                        $data = [
                            'santri_id' => $santri->santri->id,
                            'no_induk' => $santri->santri->no_induk,
                            'name' => $santri->santri->user->name,
                            'saldo' => number_format($saldo),
                            'foto' => $santri->santri->foto,
                        ];
                        return response()->json(['data' => $data], 200);
                    }
                } else {
                    $data = [
                        'santri_id' => $santri->santri->id,
                        'no_induk' => $santri->santri->no_induk,
                        'name' => $santri->santri->user->name,
                        'saldo' => number_format($saldo),
                        'foto' => $santri->santri->foto,
                    ];
                    return response()->json(['data' => $data], 200);
                }
            }

            return response()->json(['message' => 'Tidak ada data santri dengan nomor induk <strong>' . $noinduk . '</strong>'], 200);
        }
        $santri = Santri::with('user')->get(['no_induk as id', 'user_id']);
        return view('pages.transaksi.index', compact('santri'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'santri_noinduk' => 'required|numeric|digits:8|exists:santris,no_induk',
            'debit' => 'required|numeric',
            'jenis_transaksi' => 'required',
        ]);
        try {
            if ($validate['debit'] < 50000) {
                Toastr::info('Minimal setoran Rp. 50.000');
            } else {
                $santri = Santri::firstWhere('no_induk', $validate['santri_noinduk']);
                $tabungan = Tabungan::firstWhere('santri_id', $santri->id);
                $transaksi = TransaksiTabungan::create([
                    'santri_id' => $santri->id,
                    'tanggal_transaksi' => date('Y-m-d'),
                    'jenis_transaksi' => $validate['jenis_transaksi'],
                    'jumlah_transaksi' => $validate['debit'],
                    'saldo_sebelumnya' => $tabungan->saldo,
                    'saldo_saatini' => $tabungan->saldo + $validate['debit'],
                ]);
                $tabungan->update([
                    'saldo' => $tabungan->saldo + $transaksi->jumlah_transaksi,
                    'tanggal_setor' => date('Y-m-d'),
                ]);
                Toastr::success('Berhasil menyimpan data');
            }
            return redirect()->back();
        } catch (\Throwable $th) {
            dd($th->getMessage());
            Toastr::error('Gagal menyimpan data');
            return redirect()->back()->withInput();
        }
    }
    public function update(Request $request)
    {
        $validate = $request->validate([
            'santri_noinduk' => 'required|numeric|digits:8|exists:santris,no_induk',
            'kredit' => 'required|numeric',
            'jenis_transaksi' => 'required',
        ]);
        try {
            if ($validate['kredit'] < 10000) {
                Toastr::info('Minimal penarikan 10.000 atau diatasnya');
            } else {
                $santri = Santri::firstWhere('no_induk', $validate['santri_noinduk']);
                $tabungan = Tabungan::firstWhere('santri_id', $santri->id);
                if ($tabungan->saldo == 0) {
                    Toastr::info('Saldo tidak cukup, saldo saat ini ' . $tabungan->saldo);
                } else {
                    $transaksi = new TransaksiTabungan();
                    $tr_now = $transaksi->whereDate('tanggal_transaksi', now()->toDateString())->where('jenis_transaksi', 'Penarikan')->get();
                    if (!$tr_now->isEmpty()) {
                        Toastr::info('Santri dengan nomor induk ' . "$santri->no_induk" . ' telah selesai melakukan penarikan');
                    } else {
                        $transaksi = TransaksiTabungan::create([
                            'santri_id' => $santri->id,
                            'tanggal_transaksi' => date('Y-m-d'),
                            'jenis_transaksi' => $validate['jenis_transaksi'],
                            'jumlah_transaksi' => $validate['kredit'],
                            'saldo_saatini' => $tabungan->saldo - $validate['kredit'],
                            'tujuan' => request()->get('tujuan') != null ? request()->get('tujuan') : 'Uang Jajan'
                        ]);

                        $tabungan->update([
                            'saldo' => $tabungan->saldo - $transaksi->jumlah_transaksi,
                            'tanggal_setor' => date('Y-m-d'),
                        ]);
                        $this->send_message($santri, 'Uang Jajan', number_format($validate['kredit']));
                        Toastr::success('Berhasil menyimpan data');
                    }
                }
            }
            return redirect()->back()->withQuery(['jenis_transaksi' => 'Penarikan']);
        } catch (\Throwable $th) {
            Toastr::error('Gagal menyimpan data');
            return redirect()->back()->withInput();
        }
    }
    public function send_message($santri, $tujuan, $nominal)
    {
        $sender = env('WA_SENDER_NUMBER', '6285179695497');
        $number = isset($santri->whatsapp) ? $santri->whatsapp : '';
        $apiKey = env('WA_API_KEY', 'KnMhRlylvKNfCblMIVNHTM5aerEGbV');
        $tanggal = now('Asia/Jakarta')->format('d-F-Y H:i:s');
        $pesan = "*Assalamualaikum Wr. Wb.*\n\n";
        $pesan .= "Hormat Kami,\n";
        $pesan .= "Kami dari pengurus Pondok Pesantren *Al-Ibrohimy Masaran Sentol Daya Pragaan Sumenep* ingin memberitahukan bahwa santri sebagaimana data berikut telah melakukan transaksi tarik tunai tabungan:\n\n";
        $pesan .= "Nama: *{$santri->user->name}*\n";
        $pesan .= "Nominal: *Rp. {$nominal}*\n";
        $pesan .= "Tujuan: *{$tujuan}*\n";
        $pesan .= "Tanggal: *{$tanggal}*\n\n";
        $pesan .= "Demikian pemberitahuan ini kami sampaikan terimakasih, dan mohon maaf telah mengganggu waktu anda.\n";
        $pesan .= "Sekian dari kami Wassalamualaikuk Wr. Wb.\n\n";
        $pesan .= "Hormat kami,\n";
        $pesan .= "*Pengurus Pondok Pesantren Al-Ibrohimy*";
        $params = [
            'api_key' => $apiKey,
            'sender' => $sender,
            'number' => $number,
            'message' => $pesan,
        ];

        // return $params;
        $url = 'https://connect.labelin.co/send-message';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
