<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //User::factory(10)->create();
        User::factory()->count(1)
            ->has(UserProfile::factory(1))
            ->create()
            ->each(
                function ($user) {
                    $user->assignRole('super-admin');
                }
            );

        User::factory()->count(6)
            ->has(UserProfile::factory(1))
            ->create()
            ->each(
                function ($user) {
                    $user->assignRole('employee');
                }
            );

        User::factory()->count(10)
            ->has(UserProfile::factory(1))
            ->create()
            ->each(
                function ($user) {
                    $user->assignRole('candidate');
                }
            );
    }
}
