<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\{Jail, Role, Ward};
use Illuminate\Database\Seeder;

class JailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $wards = Ward::all();
        $wards->each(function (Ward $ward) {
            Jail::factory()->for($ward)->count(rand(2, 5))->create();
        });
        $prisoner_role = Role::where('slug', RoleEnum::PRISONER->value)->first();
        $prisoners = $prisoner_role->users;
        $jails = Jail::all();
        $jails->each(function (Jail $jail) use ($prisoners) {
            $jail->users()->attach($prisoners->shift($jail->capacity));
        });
    }
}
