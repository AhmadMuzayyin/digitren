<?php

namespace App\Http\Controllers;

use Toastr;
use App\Models\User;
use App\Models\Santri;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Http\Requests\Profil\AccountRequest;
use App\Http\Requests\Profil\BiodataRequest;
use App\Models\AlamatSantri;

class ProfilController extends Controller
{
    public function show(User $user)
    {
        $user->with('santri');

        return view('pages.profil.index', compact('user'));
    }
    public function account(AccountRequest $request, User $user)
    {
        try {
            $user->update($request->validated());
            Toastr::success('Berhasil merubdah data');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Gagal merubah data');
            return redirect()->back();
        }
    }
    public function biodata(BiodataRequest $request, User $user)
    {
        try {
            $validated = $request->validated();
            $foto = $request->file('foto');
            if (isset($foto) == true) {
                $path = storage_path('app/public/uploads/santri/');
                $filename = $foto->hashName();
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                Image::make($foto->getRealPath())->resize(240, 295, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })->save($path . $filename);
                $validated['foto'] = $filename;
            } else {
                $validated['foto'] = $user->santri->foto;
            }
            Santri::where('user_id', $user->id)->update([
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'nik' => $validated['nik'],
                'kk' => $validated['kk'],
                'whatsapp' => $validated['whatsapp'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'foto' => $validated['foto'],
            ]);
            AlamatSantri::where('santri_id', $user->santri->id)->update([
                'provinsi_id' => $validated['provinsi_id'],
                'kabupaten_id' => $validated['kabupaten_id'],
                'kecamatan_id' => $validated['kecamatan_id'],
                'kelurahan_id' => $validated['kelurahan_id'],
                'dusun' => $validated['dusun'],
            ]);
            Toastr::success('Berhasil merubah data');
            return redirect()->back();
        } catch (\Throwable $th) {
            dd($th->getMessage());
            Toastr::error('Gagal merubah data');
            return redirect()->back();
        }
    }
}
