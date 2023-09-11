<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Toastr;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('pages.users.index', compact('users'));
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|min:5|max:255',
            'email' => "required|email|unique:users,email",
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|confirmed|string|min:8|regex:/[0-9]+/'
        ]);
        try {
            User::create($validate);
            Toastr::success('Berhasil menambah data');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::success('Gagal menambah data');
            return redirect()->back();
        }
    }
    public function update(Request $request, User $user)
    {
        $validate = $request->validate([
            'name' => 'required|min:5|max:255',
            'email' => "required|email|unique:users,email,$user->id",
            'role_id' => 'required|exists:roles,id',
        ]);
        try {
            $user->update($validate);
            Toastr::success('Berhasil memperbarui data');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::success('Gagal memperbarui data');
            return redirect()->back();
        }
    }
    public function destroy(User $user)
    {
        try {
            $user->delete();
            Toastr::success('Berhasil menghapus data');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::success('Gagal menghapus data');
            return redirect()->back();
        }
    }
}
