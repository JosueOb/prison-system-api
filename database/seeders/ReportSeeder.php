<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\{Report, Role};
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        $guard_role = Role::where('slug', RoleEnum::GUARD->value)->first();
        $guards = $guard_role->users;
        $guards->each(function ($guard) {
            Report::factory()->for($guard)->create();
        });
    }
}
