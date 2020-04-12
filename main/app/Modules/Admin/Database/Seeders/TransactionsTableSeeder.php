<?php
namespace App\Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;

class TransactionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('transactions')->delete();
        
        \DB::table('transactions')->insert(array (
            0 => 
            array (
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 27000.0,
                'created_at' => NULL,
            ),
            1 => 
            array (
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 22500.0,
                'created_at' => NULL,
            ),
            2 => 
            array (
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 4500.0,
                'created_at' => NULL,
            ),
            3 => 
            array (
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 9000.0,
                'created_at' => NULL,
            ),
            4 => 
            array (
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 13500.0,
                'created_at' => NULL,
            ),
            5 => 
            array (
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 13500.0,
                'created_at' => NULL,
            ),
            6 => 
            array (
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 3000.0,
                'created_at' => NULL,
            ),
            7 => 
            array (
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 2500.0,
                'created_at' => NULL,
            ),
            8 => 
            array (
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 500.0,
                'created_at' => NULL,
            ),
            9 => 
            array (
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 1000.0,
                'created_at' => NULL,
            ),
            10 => 
            array (
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 1500.0,
                'created_at' => NULL,
            ),
            11 => 
            array (
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 1500.0,
                'created_at' => NULL,
            ),
            12 => 
            array (
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 4000.0,
                'created_at' => NULL,
            ),
            13 => 
            array (
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 12000.0,
                'created_at' => NULL,
            ),
            14 => 
            array (
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 4000.0,
                'created_at' => NULL,
            ),
            15 => 
            array (
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 4000.0,
                'created_at' => NULL,
            ),
            16 => 
            array (
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 10000.0,
                'created_at' => NULL,
            ),
            17 => 
            array (
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 6000.0,
                'created_at' => NULL,
            ),
            18 => 
            array (
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 5000.0,
                'created_at' => NULL,
            ),
            19 => 
            array (
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 40000.0,
                'created_at' => NULL,
            ),
            20 => 
            array (
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 40000.0,
                'created_at' => NULL,
            ),
            21 => 
            array (
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 20000.0,
                'created_at' => NULL,
            ),
            22 => 
            array (
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 20000.0,
                'created_at' => NULL,
            ),
            23 => 
            array (
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 10000.0,
                'created_at' => NULL,
            ),
            24 => 
            array (
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 5000.0,
                'created_at' => NULL,
            ),
            25 => 
            array (
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 15000.0,
                'created_at' => NULL,
            ),
            26 => 
            array (
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 5000.0,
                'created_at' => NULL,
            ),
            27 => 
            array (
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 5000.0,
                'created_at' => NULL,
            ),
            28 => 
            array (
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 12500.0,
                'created_at' => NULL,
            ),
            29 => 
            array (
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 7500.0,
                'created_at' => NULL,
            ),
            30 => 
            array (
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 10000.0,
                'created_at' => NULL,
            ),
            31 => 
            array (
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 30000.0,
                'created_at' => NULL,
            ),
            32 => 
            array (
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 10000.0,
                'created_at' => NULL,
            ),
            33 => 
            array (
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 10000.0,
                'created_at' => NULL,
            ),
            34 => 
            array (
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 25000.0,
                'created_at' => NULL,
            ),
            35 => 
            array (
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 15000.0,
                'created_at' => NULL,
            ),
            36 => 
            array (
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 2000.0,
                'created_at' => NULL,
            ),
            37 => 
            array (
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 6000.0,
                'created_at' => NULL,
            ),
            38 => 
            array (
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 2000.0,
                'created_at' => NULL,
            ),
            39 => 
            array (
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 2000.0,
                'created_at' => NULL,
            ),
            40 => 
            array (
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 5000.0,
                'created_at' => NULL,
            ),
            41 => 
            array (
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 3000.0,
                'created_at' => NULL,
            ),
            42 => 
            array (
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 2000.0,
                'created_at' => NULL,
            ),
            43 => 
            array (
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 6000.0,
                'created_at' => NULL,
            ),
            44 => 
            array (
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 2000.0,
                'created_at' => NULL,
            ),
            45 => 
            array (
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 2000.0,
                'created_at' => NULL,
            ),
            46 => 
            array (
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 5000.0,
                'created_at' => NULL,
            ),
            47 => 
            array (
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 3000.0,
                'created_at' => NULL,
            ),
            48 => 
            array (
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 9000.0,
                'created_at' => '2020-04-11 22:45:10',
            ),
            49 => 
            array (
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 27000.0,
                'created_at' => '2020-04-11 22:45:10',
            ),
            50 => 
            array (
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 9000.0,
                'created_at' => '2020-04-11 22:45:10',
            ),
            51 => 
            array (
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 9000.0,
                'created_at' => '2020-04-11 22:45:10',
            ),
            52 => 
            array (
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 22500.0,
                'created_at' => '2020-04-11 22:45:10',
            ),
            53 => 
            array (
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 13500.0,
                'created_at' => '2020-04-11 22:45:10',
            ),
            54 => 
            array (
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 4000.0,
                'created_at' => '2020-04-11 22:45:10',
            ),
            55 => 
            array (
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 12000.0,
                'created_at' => '2020-04-11 22:45:10',
            ),
            56 => 
            array (
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 4000.0,
                'created_at' => '2020-04-11 22:45:10',
            ),
            57 => 
            array (
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 4000.0,
                'created_at' => '2020-04-11 22:45:10',
            ),
            58 => 
            array (
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 10000.0,
                'created_at' => '2020-04-11 22:45:10',
            ),
            59 => 
            array (
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 6000.0,
                'created_at' => '2020-04-11 22:45:10',
            ),
        ));

        
    }
}