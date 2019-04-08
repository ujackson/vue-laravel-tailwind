<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * create admin user
         *
         */
        $admin_role = Role::where('name', 'admin')->first();

        $admin = new User();
        $admin->name = 'System Admin';
        $admin->email = 'admin@' . request()->getHttpHost();
        $admin->password = Hash::make('secret');
        $admin->email_verified_at = now();
        $admin->save();
        $admin->roles()->attach($admin_role);
    }
}
