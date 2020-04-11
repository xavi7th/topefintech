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
            ),
            1 => 
            array (
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 22500.0,
            ),
            2 => 
            array (
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 4500.0,
            ),
            3 => 
            array (
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 9000.0,
            ),
            4 => 
            array (
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 13500.0,
            ),
            5 => 
            array (
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 13500.0,
            ),
            6 => 
            array (
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 3000.0,
            ),
            7 => 
            array (
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 2500.0,
            ),
            8 => 
            array (
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 500.0,
            ),
            9 => 
            array (
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 1000.0,
            ),
            10 => 
            array (
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 1500.0,
            ),
            11 => 
            array (
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 1500.0,
            ),
            12 => 
            array (
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 4000.0,
            ),
            13 => 
            array (
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 12000.0,
            ),
            14 => 
            array (
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 4000.0,
            ),
            15 => 
            array (
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 4000.0,
            ),
            16 => 
            array (
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 10000.0,
            ),
            17 => 
            array (
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 6000.0,
            ),
            18 => 
            array (
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 5000.0,
            ),
            19 => 
            array (
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 40000.0,
            ),
            20 => 
            array (
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 40000.0,
            ),
            21 => 
            array (
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 20000.0,
            ),
            22 => 
            array (
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 20000.0,
            ),
            23 => 
            array (
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 10000.0,
            ),
            24 => 
            array (
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 5000.0,
            ),
            25 => 
            array (
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 15000.0,
            ),
            26 => 
            array (
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 5000.0,
            ),
            27 => 
            array (
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 5000.0,
            ),
            28 => 
            array (
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 12500.0,
            ),
            29 => 
            array (
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 7500.0,
            ),
            30 => 
            array (
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 10000.0,
            ),
            31 => 
            array (
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 30000.0,
            ),
            32 => 
            array (
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 10000.0,
            ),
            33 => 
            array (
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 10000.0,
            ),
            34 => 
            array (
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 25000.0,
            ),
            35 => 
            array (
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 15000.0,
            ),
            36 => 
            array (
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 2000.0,
            ),
            37 => 
            array (
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 6000.0,
            ),
            38 => 
            array (
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 2000.0,
            ),
            39 => 
            array (
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 2000.0,
            ),
            40 => 
            array (
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 5000.0,
            ),
            41 => 
            array (
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 3000.0,
            ),
            42 => 
            array (
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 2000.0,
            ),
            43 => 
            array (
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 6000.0,
            ),
            44 => 
            array (
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 2000.0,
            ),
            45 => 
            array (
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 2000.0,
            ),
            46 => 
            array (
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 5000.0,
            ),
            47 => 
            array (
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 3000.0,
            ),
        ));

        
    }
}