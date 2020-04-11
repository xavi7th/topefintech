<?php
namespace App\Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;

class GosTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('gos_types')->delete();
        
        \DB::table('gos_types')->insert(array (
            0 => 
            array (
                'name' => 'Birthday',
            ),
            1 => 
            array (
                'name' => 'Exam Sorting',
            ),
            2 => 
            array (
                'name' => 'House Rent',
            ),
            3 => 
            array (
                'name' => 'Investment',
            ),
            4 => 
            array (
                'name' => 'Marriage',
            ),
            5 => 
            array (
                'name' => 'New Car',
            ),
            6 => 
            array (
                'name' => 'New Shoes',
            ),
            7 => 
            array (
                'name' => 'NYSC',
            ),
            8 => 
            array (
                'name' => 'School Fees',
            ),
        ));

        
    }
}