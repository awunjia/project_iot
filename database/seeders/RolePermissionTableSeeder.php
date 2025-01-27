<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Role::where('name', 'super_admin')->first();
        $superAdmin->permissions()->attach(Permission::all());

        $admin = Role::where('name', 'admin')->first();
        $admin->permissions()->attach(Permission::whereIn('name', ['create_user', 'edit_user'])->get());
    }
}
