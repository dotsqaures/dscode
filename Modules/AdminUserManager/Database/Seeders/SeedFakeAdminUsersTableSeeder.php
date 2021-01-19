<?php

namespace Modules\AdminUserManager\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class SeedFakeAdminUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('admin_roles')->insert([
            'title' => 'Super Admin',
            'is_default' => 1,
            'created_at'=> Carbon::now()
        ]);

        DB::table('admin_roles')->insert([
            'title' => 'Admin',
            'created_at'=> Carbon::now()
        ]);

        
        factory(\Modules\AdminUserManager\Entities\AdminUser::class, 20)->create();
        factory(\Modules\AdminUserManager\Entities\AdminRoleAdminUser::class, 20)->create();

        // $this->call("OthersTableSeeder");
    }
}
