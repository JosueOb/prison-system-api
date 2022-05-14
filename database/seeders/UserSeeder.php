<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Register users with a specific role
         */
        /*Default administrator*/
        $default_admin = config('user.admin');
        $admin_role = Role::where('slug', 'admin')->first();
        $admin_role->users()->save($default_admin);
        /*Directors | Guards | Prisoners*/
        $roles = Role::whereIn('slug', ['director', 'guard', 'prisoner'])->get();
        $roles->each(function (Role $role) {
            User::factory()->for($role)->count(rand(5, 15))->create();
        });
    }
}
