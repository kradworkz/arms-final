<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DropdownsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('dropdowns')->delete();
        
        \DB::table('dropdowns')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'none',
                'type' => 'none',
                'classification' => 'none',
                'color' => 'none',
                'status' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Operational',
                'type' => 'Asset',
                'classification' => 'Status',
                'color' => 'green',
                'status' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Maintenance',
                'type' => 'Asset',
                'classification' => 'Status',
                'color' => 'red',
                'status' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Disposed',
                'type' => 'Asset',
                'classification' => 'Status',
                'color' => 'blue',
                'status' => 1,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Borrowed',
                'type' => 'Asset',
                'classification' => 'Status',
                'color' => 'yellow',
                'status' => 1,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Pending',
                'type' => 'Request',
                'classification' => 'Status',
                'color' => 'yellow',
                'status' => 1,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Approved',
                'type' => 'Request',
                'classification' => 'Status',
                'color' => 'green',
                'status' => 1,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Lost',
                'type' => 'Request',
                'classification' => 'Status',
                'color' => 'red',
                'status' => 1,
            ),

            8 => 
            array (
                'id' => 9,
                'name' => 'Operational',
                'type' => 'Device',
                'classification' => 'Status',
                'color' => 'green',
                'status' => 1,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Non-operational',
                'type' => 'Device',
                'classification' => 'Status',
                'color' => 'red',
                'status' => 1,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'For Replacement',
                'type' => 'Device',
                'classification' => 'Status',
                'color' => 'yellow',
                'status' => 1,
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Disposed',
                'type' => 'Device',
                'classification' => 'Status',
                'color' => 'black',
                'status' => 1,
            ),




            12 => 
            array (
                'id' => 13,
                'name' => 'Sensor Device',
                'type' => 'chip',
                'classification' => 'Category',
                'color' => 'blue',
                'status' => 1,
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Transportation',
                'type' => 'trip',
                'classification' => 'Category',
                'color' => 'green',
                'status' => 1,
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Medical Equipment',
                'type' => 'health',
                'classification' => 'Category',
                'color' => 'red',
                'status' => 1,
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Machinery',
                'type' => 'cog',
                'classification' => 'Category',
                'color' => 'yellow',
                'status' => 1,
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Others',
                'type' => 'folder-open',
                'classification' => 'Category',
                'color' => 'gray',
                'status' => 1,
            ),
            
            17 => 
            array (
                'id' => 18,
                'name' => 'Automated Rain Gauge',
                'type' => 'cloud-rain',
                'classification' => 'Device',
                'color' => 'yellow',
                'status' => 1,
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Automated Weather Station',
                'type' => 'cloud',
                'classification' => 'Device',
                'color' => 'green',
                'status' => 1,
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Water Level Monitoring System',
                'type' => 'water',
                'classification' => 'Device',
                'color' => 'blue',
                'status' => 1,
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Triggering Alerting Station',
                'type' => 'alarm-exclamation',
                'classification' => 'Device',
                'color' => 'gray',
                'status' => 1,
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Shallow Landslide Early Warning System',
                'type' => 'landscape',
                'classification' => 'Device',
                'color' => 'red',
                'status' => 1,
            ),
            22 =>
            array (
                'id' => 23,
                'name' => 'TANDEM',
                'type' => 'share-square',
                'classification' => 'Device',
                'color' => 'red',
                'status' => 1,
            ),
            
        ));
        
        
    }
}