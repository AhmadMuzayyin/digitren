<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = config('permission.admin');
        $listPermissionAdmin = [];
        $superAdminPermission = [];
        foreach ($admin as $label => $permissions) {
            foreach ($permissions as $permission) {
                $listPermissionAdmin[] = [
                    'name' => $permission,
                    'guard_name' => 'web',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),

                ];
                // hak akses super admin
                $superAdminPermission[] = $permission;
            }
        }
        $keuangan = config('permission.keuangan');
        $keuanganPermission = [];
        foreach ($keuangan as $label => $permissions) {
            foreach ($permissions as $permission) {
                $keuanganPermission[] = $permission;
            }
        }
        $pengurus = config('permission.pengurus');
        $pengurusPermission = [];
        foreach ($pengurus as $label => $permissions) {
            foreach ($permissions as $permission) {
                $pengurusPermission[] = $permission;
            }
        }
        $santri = config('permission.santri');
        $santriPermission = [];
        foreach ($santri as $label => $permissions) {
            foreach ($permissions as $permission) {
                $santriPermission[] = $permission;
            }
        }

        Permission::insert($listPermissionAdmin);
        $role = Role::create([
            'name' => config('permission.roles')[0],
            'guard_name' => 'web',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $keuangan = Role::create([
            'name' => config('permission.roles')[1],
            'guard_name' => 'web',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $pengurus = Role::create([
            'name' => config('permission.roles')[2],
            'guard_name' => 'web',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $santri = Role::create([
            'name' => config('permission.roles')[3],
            'guard_name' => 'web',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $alumni = Role::create([
            'name' => config('permission.roles')[4],
            'guard_name' => 'web',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $role->givePermissionTo($superAdminPermission);
        User::find(1)->assignRole('Administrator');

        $keuangan->givePermissionTo($keuanganPermission);
        User::find(2)->assignRole('Keuangan');

        $pengurus->givePermissionTo($pengurusPermission);
        User::find(3)->assignRole('Pengurus');
        $santri->givePermissionTo($santriPermission);
        // User::find(4)->assignRole('Santri');
    }
}
