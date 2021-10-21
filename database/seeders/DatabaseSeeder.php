<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            'name' => 'Ra-ouf Jumli',
            'email' => 'admin@arms.com',
            'password' => bcrypt('dost9ict'),
            'type' => 'Administrator',
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
            'email_verified_at' => now(),
        ]);

        \DB::table('users')->insert([
            'name' => 'Eden Galleno',
            'email' => 'gallenoeden09@gmail.com',
            'password' => bcrypt('eden123456'),
            'type' => 'Administrator',
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
            'email_verified_at' => now(),
        ]);

        \DB::table('members')->insert([
            'name' => 'Local Government Unit',
            'acronym' => 'LGU',
            'avatar' => 'lgu.png',
            'status' => 'Active',
            'type' => 'LGU',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \DB::table('dropdowns')->insert([
            'id' => 1,
            'name' => 'none',
            'type' => 'none',
            'classification' => 'none',
            'color' => 'none',
            'status' => 1,
        ]);

        $this->call(LocationRegionsTableSeeder::class);
        $this->call(LocationProvincesTableSeeder::class);
        $this->call(LocationMunicipalitiesTableSeeder::class);
        $this->call(DropdownsTableSeeder::class);
    }
}
