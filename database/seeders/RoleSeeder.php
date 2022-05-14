<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default_role_names = collect([
            'admin', 'director', 'guard', 'prisoner'
        ]);
        // Register default roles using Eloquent model
        $default_role_names->each(function ($role_name) {
            Role::create([
                'name' => Str::title($role_name),
                'slug' => Str::slug($role_name),
            ]);
        });
    }
}
