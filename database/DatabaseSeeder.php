<?php

namespace Database\Seeders;

use App\Models\Agency\Agency;
use App\Models\Candidate\Candidate;
use App\Models\Contract\Contract;
use App\Models\Employer\Employer;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Tenant;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("Roles Done");

        DB::table('users')->insert([
            'role_id' => Role::where('name', '=', 'admin')->pluck('id')->first(),
            'first_name' => 'Mr.',
            'last_name' => 'Robot',
            'email' => 'robot@pss.com',
            'password' => Hash::make('Vintrix@pss'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        $this->command->info("Admin Done");

        User::factory(300)->create();
        $this->command->info("Users Done");


        // ##
        User::whereHas('role', function ($query) {
            $query->where('name', 'agency');
        })->get()->each(function ($user) {
            Agency::factory(1)->create(
                [
                    'user_id' =>  $user->id
                ]
            );
        });
        $this->command->info("Agency Done");

        User::factory(500)->create(['role_id' => Role::where('name', '=', 'candidate')->pluck('id')->first()]);

        // ##
        Agency::all()->each(function ($agency) {
            User::whereHas('role', function ($query) {
                $query->where('name', 'candidate');
            })->get()->random(5)->each(function ($user) use ($agency) {
                if (!Candidate::where('user_id', $user->id)->exists()) {
                    Candidate::factory(1)->create(
                        [
                            'user_id' =>  $user->id,
                            'agency_id' => $agency->id
                        ]
                    );
                }
            });
        });


        User::whereHas('role', function ($query) {
            $query->where('name', 'candidate');
        })->get()->each(function ($user) {

            if (!Candidate::where('user_id', $user->id)->exists() && Candidate::where('agency_id', null)) {
                Candidate::factory(1)->create(
                    [
                        'user_id' =>  $user->id,
                    ]
                );
            }
        });


        ##
        User::whereHas('role', function ($query) {
            $query->where('name', 'employer');
        })->get()->each(function ($user) {
            Employer::factory(1)->create(
                [
                    'user_id' =>  $user->id
                ]
            );
        });
        $this->command->info("Employer Done");



        $this->command->info("Candidate Done");

        $tenant = new Tenant();
        $tenant->name = 'Anurag Deep';
        $tenant->save();

        $tenant->domains()->create([
            'domain' => 'test.localhost'
        ]);

        Contract::factory(100)->create();

        $this->command->info("_____________________");
        $this->command->info("# Admin Cred");
        $this->command->line('Email: robot@pss.com , Password: Vintrix@pss');
    }
}
