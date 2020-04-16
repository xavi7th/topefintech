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
                'id' => 1,
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 27000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 22500.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 4500.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 9000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 13500.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 13500.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 3000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 2500.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 500.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 1000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 1500.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 1500.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 4000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 12000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 4000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 4000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 10000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 6000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 5000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 40000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 40000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 20000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 20000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 10000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 5000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 15000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 5000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 5000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 12500.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 7500.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            30 => 
            array (
                'id' => 31,
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 10000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            31 => 
            array (
                'id' => 32,
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 30000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            32 => 
            array (
                'id' => 33,
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 10000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            33 => 
            array (
                'id' => 34,
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 10000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            34 => 
            array (
                'id' => 35,
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 25000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            35 => 
            array (
                'id' => 36,
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 15000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            36 => 
            array (
                'id' => 37,
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 2000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            37 => 
            array (
                'id' => 38,
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 6000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            38 => 
            array (
                'id' => 39,
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 2000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            39 => 
            array (
                'id' => 40,
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 2000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            40 => 
            array (
                'id' => 41,
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 5000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            41 => 
            array (
                'id' => 42,
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 3000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            42 => 
            array (
                'id' => 43,
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 2000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            43 => 
            array (
                'id' => 44,
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 6000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            44 => 
            array (
                'id' => 45,
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 2000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            45 => 
            array (
                'id' => 46,
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 2000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            46 => 
            array (
                'id' => 47,
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 5000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            47 => 
            array (
                'id' => 48,
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 3000.0,
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            48 => 
            array (
                'id' => 49,
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 9000.0,
                'description' => NULL,
                'created_at' => '2020-04-11 22:45:10',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            49 => 
            array (
                'id' => 50,
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 27000.0,
                'description' => NULL,
                'created_at' => '2020-04-11 22:45:10',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            50 => 
            array (
                'id' => 51,
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 9000.0,
                'description' => NULL,
                'created_at' => '2020-04-11 22:45:10',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            51 => 
            array (
                'id' => 52,
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 9000.0,
                'description' => NULL,
                'created_at' => '2020-04-11 22:45:10',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            52 => 
            array (
                'id' => 53,
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 22500.0,
                'description' => NULL,
                'created_at' => '2020-04-11 22:45:10',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            53 => 
            array (
                'id' => 54,
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 13500.0,
                'description' => NULL,
                'created_at' => '2020-04-11 22:45:10',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            54 => 
            array (
                'id' => 55,
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 4000.0,
                'description' => NULL,
                'created_at' => '2020-04-11 22:45:10',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            55 => 
            array (
                'id' => 56,
                'savings_id' => 4,
                'trans_type' => 'deposit',
                'amount' => 12000.0,
                'description' => NULL,
                'created_at' => '2020-04-11 22:45:10',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            56 => 
            array (
                'id' => 57,
                'savings_id' => 5,
                'trans_type' => 'deposit',
                'amount' => 4000.0,
                'description' => NULL,
                'created_at' => '2020-04-11 22:45:10',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            57 => 
            array (
                'id' => 58,
                'savings_id' => 6,
                'trans_type' => 'deposit',
                'amount' => 4000.0,
                'description' => NULL,
                'created_at' => '2020-04-11 22:45:10',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            58 => 
            array (
                'id' => 59,
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 10000.0,
                'description' => NULL,
                'created_at' => '2020-04-11 22:45:10',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            59 => 
            array (
                'id' => 60,
                'savings_id' => 3,
                'trans_type' => 'deposit',
                'amount' => 6000.0,
                'description' => NULL,
                'created_at' => '2020-04-11 22:45:10',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            60 => 
            array (
                'id' => 61,
                'savings_id' => 2,
                'trans_type' => 'deposit',
                'amount' => 16612.5,
                'description' => 'Break lock interests rollover',
                'created_at' => '2020-04-16 05:03:20',
                'updated_at' => '2020-04-16 05:03:20',
                'deleted_at' => NULL,
            ),
            61 => 
            array (
                'id' => 62,
                'savings_id' => 1,
                'trans_type' => 'deposit',
                'amount' => 208290.0,
                'description' => 'Broken lock deposit',
                'created_at' => '2020-04-16 05:03:20',
                'updated_at' => '2020-04-16 05:03:20',
                'deleted_at' => NULL,
            ),
            62 => 
            array (
                'id' => 63,
                'savings_id' => 1,
                'trans_type' => 'withdrawal',
                'amount' => 70000.0,
                'description' => 'Withdrawal from core savings balance',
                'created_at' => '2020-04-16 05:10:51',
                'updated_at' => '2020-04-16 05:10:51',
                'deleted_at' => NULL,
            ),
            63 => 
            array (
                'id' => 64,
                'savings_id' => 1,
                'trans_type' => 'withdrawal',
                'amount' => 50000.0,
                'description' => 'Charge-deductible withdrawal from core savings balance',
                'created_at' => '2020-04-16 05:12:08',
                'updated_at' => '2020-04-16 05:12:08',
                'deleted_at' => NULL,
            ),
            64 => 
            array (
                'id' => 65,
                'savings_id' => 1,
                'trans_type' => 'withdrawal',
                'amount' => 20000.0,
                'description' => 'Charge-deductible withdrawal from core savings balance',
                'created_at' => '2020-04-16 05:21:12',
                'updated_at' => '2020-04-16 05:21:12',
                'deleted_at' => NULL,
            ),
            65 => 
            array (
                'id' => 66,
                'savings_id' => 1,
                'trans_type' => 'withdrawal',
                'amount' => 20000.0,
                'description' => 'Charge-deductible withdrawal from core savings balance',
                'created_at' => '2020-04-16 05:25:42',
                'updated_at' => '2020-04-16 05:25:42',
                'deleted_at' => NULL,
            ),
            66 => 
            array (
                'id' => 67,
                'savings_id' => 1,
                'trans_type' => 'withdrawal',
                'amount' => 30000.0,
                'description' => 'Charge-deductible withdrawal from core savings balance',
                'created_at' => '2020-04-16 05:26:05',
                'updated_at' => '2020-04-16 05:26:05',
                'deleted_at' => NULL,
            ),
            67 => 
            array (
                'id' => 68,
                'savings_id' => 1,
                'trans_type' => 'withdrawal',
                'amount' => 60000.0,
                'description' => 'Charge-deductible withdrawal from core savings balance',
                'created_at' => '2020-04-16 05:26:13',
                'updated_at' => '2020-04-16 05:26:13',
                'deleted_at' => NULL,
            ),
        ));

        
    }
}