<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
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
            $role = Role::create($validate);
            if (isset($request->index)) {
                $role->givePermissionTo($request->index);
            }
            if (isset($request->view)) {
                $role->givePermissionTo($request->view);
            }
            if (isset($request->store)) {
                $role->givePermissionTo($request->store);
            }
            if (isset($request->update)) {
                $role->givePermissionTo($request->update);
            }
            if (isset($request->destroy)) {
                $role->givePermissionTo($request->destroy);
            }
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
