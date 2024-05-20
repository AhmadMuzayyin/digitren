<?php

namespace App\Http\Controllers;

use App\Helpers\Whatsapp;
use Toastr;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Requests\SettingRequest;
use App\Models\WhatsappMessage;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        $whatsapp = WhatsappMessage::first();
        return view('pages.setting.index', compact('setting', 'whatsapp'));
    }
    public function store(SettingRequest $request)
    {
        $validate = $request->validated();
        try {
            $logo = request()->file('logo');
            if (isset($logo) == true) {
                $path = storage_path('app/public/uploads/setting/');
                $filename = $logo->hashName();

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                Image::make($logo->getRealPath())->resize(240, 295, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })->save($path . $filename);
                $validate['logo'] = $filename;
            }
            $favicon = request()->file('favicon');
            if (isset($favicon) == true) {
                $path = storage_path('app/public/uploads/setting/');
                $filename = $favicon->hashName();

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                Image::make($favicon->getRealPath())->resize(240, 295, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })->save($path . $filename);
                $validate['favicon'] = $filename;
            }
            $kts_master = request()->file('kts_master');
            if (isset($kts_master) == true) {
                $path = storage_path('app/public/uploads/setting/');
                $filename = $kts_master->hashName();

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                Image::make($kts_master->getRealPath())->resize(240, 295, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })->save($path . $filename);
                $validate['kts_master'] = $filename;
            }
            Setting::updateOrCreate($validate);
            Toastr::success('Berhasil menyimpan data setting!');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Gagal menyimpan data setting!');
            return redirect()->back();
        }
    }
    public function update(SettingRequest $request, Setting $setting)
    {
        $validate = $request->validated();
        try {
            $validate['whatsapp_feature'] = $validate['whatsapp_feature'][0];
            $validate['sender'] = Whatsapp::make($validate['sender']);
            $logo = request()->file('logo');
            if (isset($logo) == true) {
                $path = storage_path('app/public/uploads/setting/');
                $filename = $logo->hashName();
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                Image::make($logo->getRealPath())->resize(240, 295, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })->save($path . $filename);
                // delete old photo from storage
                if ($setting->logo != null && file_exists($path . $setting->logo)) {
                    unlink($path . $setting->logo);
                }
                $validate['logo'] = $filename;
            }
            $favicon = request()->file('favicon');
            if (isset($favicon) == true) {
                $path = storage_path('app/public/uploads/setting/');
                $filename = $favicon->hashName();
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                Image::make($favicon->getRealPath())->resize(240, 295, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })->save($path . $filename);
                // delete old photo from storage
                if ($setting->favicon != null && file_exists($path . $setting->favicon)) {
                    unlink($path . $setting->favicon);
                }
                $validate['favicon'] = $filename;
            }
            $kts_master = request()->file('kts_master');
            if (isset($kts_master) == true) {
                $path = storage_path('app/public/uploads/setting/');
                $filename = $kts_master->hashName();
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                Image::make($kts_master->getRealPath())->resize(240, 295, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })->save($path . $filename);
                // delete old photo from storage
                if ($setting->kts_master != null && file_exists($path . $setting->kts_master)) {
                    unlink($path . $setting->kts_master);
                }
                $validate['kts_master'] = $filename;
            }
            $setting->update($validate);
            Toastr::success('Berhasil merubah data setting!');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Gagal merubah data setting!');
            return redirect()->back();
        }
    }
    public function whatsapp(Request $request)
    {
        try {
            $whatsapp = WhatsappMessage::first();
            if ($whatsapp) {
                $whatsapp->update($request->all());
            } else {
                WhatsappMessage::create($request->all());
            }
            Toastr::success('Berhasil menyimpan data');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Gagal menyimpan data');
            return redirect()->back();
        }
    }
}
