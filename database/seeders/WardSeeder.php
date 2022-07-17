<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\{Role, Ward};
use Illuminate\Database\Seeder;

class WardSeeder extends Seeder
{
    public function run(): void
    {
        $wards = Ward::factory()->count(10)->create();
        $guard_role = Role::where('slug', RoleEnum::GUARD->value)->first();
        $guards = $guard_role->users;
        $wards->each(function ($ward) use ($guards) {
            $ward->users()->attach($guards->shift());
        });
    }
}
