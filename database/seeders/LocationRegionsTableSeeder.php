<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LocationRegionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('location_regions')->delete();
        
        \DB::table('location_regions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Region I',
                'region' => 'Ilocos Region',
                'created_at' => '2020-03-10 08:00:00',
                'updated_at' => '2020-03-10 08:00:00',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Region II',
                'region' => 'Cagayan Valley',
                'created_at' => '2020-03-10 08:00:00',
                'updated_at' => '2020-03-10 08:00:00',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Region III',
                'region' => 'Central Luzon',
                'created_at' => '2020-03-10 08:00:00',
                'updated_at' => '2020-03-10 08:00:00',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Region IV-A',
                'region' => 'Calabarzon',
                'created_at' => '2020-03-10 08:00:00',
                'updated_at' => '2020-03-10 08:00:00',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Region IV-B',
                'region' => 'Mimaropa',
                'created_at' => '2020-03-10 08:00:00',
                'updated_at' => '2020-03-10 08:00:00',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Region V',
                'region' => 'Bicol Region',
                'created_at' => '2020-03-10 08:00:00',
                'updated_at' => '2020-03-10 08:00:00',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Region VI',
                'region' => 'Western Visayas',
                'created_at' => '2020-03-10 08:00:00',
                'updated_at' => '2020-03-10 08:00:00',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Region VII',
                'region' => 'Central Visayas',
                'created_at' => '2020-03-10 08:00:00',
                'updated_at' => '2020-03-10 08:00:00',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Region VIII',
                'region' => 'Eastern Visayas',
                'created_at' => '2020-03-10 08:00:00',
                'updated_at' => '2020-03-10 08:00:00',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Region IX',
                'region' => 'Zamboanga Peninsula',
                'created_at' => '2020-03-10 08:00:00',
                'updated_at' => '2020-03-10 08:00:00',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Region X',
                'region' => 'Northern Mindanao',
                'created_at' => '2020-03-10 08:00:00',
                'updated_at' => '2020-03-10 08:00:00',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Region XI',
                'region' => 'Davao Region',
                'created_at' => '2020-03-10 08:00:00',
                'updated_at' => '2020-03-10 08:00:00',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Region XII',
                'region' => 'Soccsksargen',
                'created_at' => '2020-03-10 08:00:00',
                'updated_at' => '2020-03-10 08:00:00',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'National Capital Region',
                'region' => 'NCR',
                'created_at' => '2020-03-10 08:00:00',
                'updated_at' => '2020-03-10 08:00:00',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Cordillera Administrative Region',
                'region' => 'CAR',
                'created_at' => '2020-03-10 08:00:00',
                'updated_at' => '2020-03-10 08:00:00',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Autonomous Region in Muslim Mindanao',
                'region' => 'ARMM',
                'created_at' => '2020-03-10 08:00:00',
                'updated_at' => '2020-03-10 08:00:00',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Region XIII',
                'region' => 'Caraga',
                'created_at' => '2020-03-10 08:00:00',
                'updated_at' => '2020-03-10 08:00:00',
            ),
        ));
        
        
    }
}