<?php

namespace Database\Seeders;

use App\Enums\CMS\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(['name' => RoleEnum::ADMIN, 'guard_name' => 'api-admin']);
        $operatorRole = Role::create(['name' => RoleEnum::OPERATOR, 'guard_name' => 'api-admin']);
    }
}
