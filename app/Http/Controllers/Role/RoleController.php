<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Toastr;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('pages.role.index', compact('roles'));
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|min:5|max:255|unique:roles,name',
        ]);
        try {
            Role::create($validate);
            Toastr::success('Berhasil menambah data');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::success('Gagal menambah data');
            return redirect()->back();
        }
    }
    public function update(Request $request, Role $role)
    {
        $validate = $request->validate([
            'name' => "required|min:5|max:255|unique:roles,name,$role->id",
        ]);
        try {
            $role->update($validate);
            Toastr::success('Berhasil memperbarui data');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::success('Gagal memperbarui data');
            return redirect()->back();
        }
    }
    public function destroy(Role $role)
    {
        try {
            $role->delete();
            Toastr::success('Berhasil menghapus data');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::success('Gagal menghapus data');
            return redirect()->back();
        }
    }
}
