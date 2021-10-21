<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LocationProvincesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('location_provinces')->delete();
        
        \DB::table('location_provinces')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Abra',
                'region_id' => 15,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Agusan del Norte',
                'region_id' => 17,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Agusan del Sur',
                'region_id' => 17,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Aklan',
                'region_id' => 7,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Albay',
                'region_id' => 6,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Antique',
                'region_id' => 7,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Apayao',
                'region_id' => 15,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Aurora',
                'region_id' => 3,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Basilan',
                'region_id' => 16,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Bataan',
                'region_id' => 3,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Batanes',
                'region_id' => 2,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Batangas',
                'region_id' => 4,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Benguet',
                'region_id' => 15,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Biliran',
                'region_id' => 9,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Bohol',
                'region_id' => 8,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Bukidnon',
                'region_id' => 11,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Bulacan',
                'region_id' => 3,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Cagayan',
                'region_id' => 2,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Camarines Norte',
                'region_id' => 6,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Camarines Sur',
                'region_id' => 6,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Camiguin',
                'region_id' => 11,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Capiz',
                'region_id' => 7,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'Catanduanes',
                'region_id' => 6,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Cavite',
                'region_id' => 4,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'Cebu',
                'region_id' => 8,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'Compostela Valley',
                'region_id' => 12,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'Cotabato',
                'region_id' => 13,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'Davao del Norte',
                'region_id' => 12,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'Davao del Sur',
                'region_id' => 12,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'Davao Oriental',
                'region_id' => 12,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'Eastern Samar',
                'region_id' => 9,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'Guimaras',
                'region_id' => 7,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'Ifugao',
                'region_id' => 15,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'Ilocos Norte',
                'region_id' => 1,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'Ilocos Sur',
                'region_id' => 1,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'Iloilo',
                'region_id' => 7,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'Isabela',
                'region_id' => 2,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'Kalinga',
                'region_id' => 15,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'La Union',
                'region_id' => 1,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'Laguna',
                'region_id' => 4,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'Lanao del Norte',
                'region_id' => 11,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'Lanao del Sur',
                'region_id' => 16,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'Leyte',
                'region_id' => 9,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'Maguindanao',
                'region_id' => 16,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'Marinduque',
                'region_id' => 1,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'Masbate',
                'region_id' => 6,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'Metro Manila',
                'region_id' => 1,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'Misamis Occidental',
                'region_id' => 11,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'Misamis Oriental',
                'region_id' => 11,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'Mountain Province',
                'region_id' => 15,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'Negros Occidental',
                'region_id' => 7,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'Negros Oriental',
                'region_id' => 8,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'Northern Samar',
                'region_id' => 9,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'Nueva Ecija',
                'region_id' => 3,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'Nueva Vizcaya',
                'region_id' => 2,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'Occidental Mindoro',
                'region_id' => 5,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            56 => 
            array (
                'id' => 57,
                'name' => 'Oriental Mindoro',
                'region_id' => 5,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            57 => 
            array (
                'id' => 58,
                'name' => 'Palawan',
                'region_id' => 5,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            58 => 
            array (
                'id' => 59,
                'name' => 'Pampanga',
                'region_id' => 3,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            59 => 
            array (
                'id' => 60,
                'name' => 'Pangasinan',
                'region_id' => 1,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            60 => 
            array (
                'id' => 61,
                'name' => 'Quezon',
                'region_id' => 4,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            61 => 
            array (
                'id' => 62,
                'name' => 'Quirino',
                'region_id' => 2,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            62 => 
            array (
                'id' => 63,
                'name' => 'Rizal',
                'region_id' => 4,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            63 => 
            array (
                'id' => 64,
                'name' => 'Romblon',
                'region_id' => 5,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            64 => 
            array (
                'id' => 65,
                'name' => 'Samar',
                'region_id' => 9,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            65 => 
            array (
                'id' => 66,
                'name' => 'Sarangani',
                'region_id' => 13,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            66 => 
            array (
                'id' => 67,
                'name' => 'Siquijor',
                'region_id' => 8,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            67 => 
            array (
                'id' => 68,
                'name' => 'Sorsogon',
                'region_id' => 6,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            68 => 
            array (
                'id' => 69,
                'name' => 'South Cotabato',
                'region_id' => 13,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            69 => 
            array (
                'id' => 70,
                'name' => 'Southern Leyte',
                'region_id' => 9,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            70 => 
            array (
                'id' => 71,
                'name' => 'Sultan Kudarat',
                'region_id' => 13,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            71 => 
            array (
                'id' => 72,
                'name' => 'Sulu',
                'region_id' => 16,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            72 => 
            array (
                'id' => 73,
                'name' => 'Surigao del Norte',
                'region_id' => 17,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            73 => 
            array (
                'id' => 74,
                'name' => 'Surigao del Sur',
                'region_id' => 17,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            74 => 
            array (
                'id' => 75,
                'name' => 'Tarlac',
                'region_id' => 3,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            75 => 
            array (
                'id' => 76,
                'name' => 'Tawi-Tawi',
                'region_id' => 16,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            76 => 
            array (
                'id' => 77,
                'name' => 'Zambales',
                'region_id' => 3,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            77 => 
            array (
                'id' => 78,
                'name' => 'Zamboanga del Norte',
                'region_id' => 10,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            78 => 
            array (
                'id' => 79,
                'name' => 'Zamboanga del Sur',
                'region_id' => 10,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            79 => 
            array (
                'id' => 80,
                'name' => 'Zamboanga Sibugay',
                'region_id' => 10,
                'created_at' => '2020-03-22 13:11:50',
                'updated_at' => '2020-03-22 13:11:50',
            ),
            80 => 
            array (
                'id' => 81,
                'name' => 'NCR - First District',
                'region_id' => 14,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            81 => 
            array (
                'id' => 82,
                'name' => 'NCR - Second District',
                'region_id' => 14,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            82 => 
            array (
                'id' => 83,
                'name' => 'NCR - Third District ',
                'region_id' => 14,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            83 => 
            array (
                'id' => 84,
                'name' => 'NCR - Fourth District',
                'region_id' => 14,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}