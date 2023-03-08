<?php

namespace Database\Seeders;

use App\Enums\CMS\AdminStatusEnum;
use App\Enums\CMS\RoleEnum;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::create([
            'name' => 'Admin',
            'login_id' => 'admin',
            'password' => 'password',
            'status' => AdminStatusEnum::ACTIVE,
        ]);
        $admin->assignRole(RoleEnum::ADMIN);

        $operator = Admin::create([
            'name' => 'Operator',
            'login_id' => 'operator',
            'password' => 'password',
            'status' => AdminStatusEnum::ACTIVE,
        ]);
        $operator->assignRole(RoleEnum::OPERATOR);
    }
}
