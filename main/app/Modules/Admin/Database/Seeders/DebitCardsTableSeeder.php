<?php
namespace App\Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;

class DebitCardsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('debit_cards')->delete();
        
        \DB::table('debit_cards')->insert(array (
            0 => 
            array (
                'app_user_id' => 2,
                'pan' => 'eyJpdiI6IlAwSnM4MUIxSXUzeTRJc1FuTDJnNXc9PSIsInZhbHVlIjoiN2hUMFRQUFoyQVVYOUYwSUU2UGJVN1RzVVIwdEpYNlhCRDA0RFpiNkNkYz0iLCJtYWMiOiJiM2RmNDFhMTI4MDdlMjYyMjBjMWVmYTBkZWQ5ZmE2YTQxZDNlOTZkZmRkODYyM2VkZTc1NGVmMDU0MmE0ZTAyIn0=',
                'pan_hash' => '$2y$10$7R227s5MkKQsd2dJQBCGpOHNtyVIDViitEF2Bx5Sv0y7HANoLzmNu',
                'month' => '8',
                'year' => '2022',
                'cvv' => 'eyJpdiI6ImR0WEc3bUVKeFFSTjFvY2o2bktwckE9PSIsInZhbHVlIjoiZWs0eG8zSnYyRGRjb1VxRCt0Um9IZz09IiwibWFjIjoiMjE1YzI3NDkzNmI5ZjRiZmNkMDY5NTI2ZDNmZWNmOThmOGMyZTdlNmIyZTI0YzU5MmQ5MTFlMmNjM2VjMzlmYSJ9',
                'cvv_hash' => '$2y$10$NNFqe8JlXrOkwTlThfeU8uIjCsXEJODvn9hYQ3VzBo3bFR3h6JoBO',
                'is_default' => 1,
            ),
            1 => 
            array (
                'app_user_id' => 2,
                'pan' => 'eyJpdiI6IjFlVWNiRWMwUmJGQ3lZbjV1NFhpZHc9PSIsInZhbHVlIjoiRU1qVG9uWXU2ZlNqN2l0WEh6ZENmXC9YaldZTlBDS1wvUEthU2NlajdLYzJFPSIsIm1hYyI6IjRhZDFmNzI0ZmUwNDIwYTM0MzMxODBhNmZmYzkwY2E4Y2I4MzgxMDIxNzNkOTViOGFiYWVjNmM4MjQ0Mzk4OTcifQ==',
                'pan_hash' => '$2y$10$kbls1pkDn9T1b1xAPxtD6.0YVSkEdxbfFUq/6hXrcir7QiUWQyWp.',
                'month' => '8',
                'year' => '2022',
                'cvv' => 'eyJpdiI6Im5EK2pYdWxoZmlsV0lDK1FJRkR1SkE9PSIsInZhbHVlIjoicFN4Z2RiYlZKM0FMQ1JLSFA3NnVTUT09IiwibWFjIjoiYzNjOTJhMDAxMDc2N2VhZjYxNTY5MTYwYTE4MmJhMGQ1MzUzYWE1MDdkM2IzOWUxNDMxNjdiYTdiYTE1NzY1YiJ9',
                'cvv_hash' => '$2y$10$VuNlBz1sXs4Tr.PH6HLKyeMmOt406QCCU4PGH8L9P7A4WbCOTwFeq',
                'is_default' => 0,
            ),
            2 => 
            array (
                'app_user_id' => 2,
                'pan' => 'eyJpdiI6IitUUGRRakdITmN1RW8xOE9MNHJza1E9PSIsInZhbHVlIjoiT0p4b2Z5MlViRHNVZW9uOCtxcEdRbGUrUGNrdjNwRTd4SUhXTHdPR0FwWT0iLCJtYWMiOiJmZmJkZWVlODc3NjYzOTEwMGYxMjk0NmUzOWY0YzZmMDlhNDhhMTk2MzE0NTdlZmRiYTdmYjkwZTcyYmJlYzYzIn0=',
                'pan_hash' => '$2y$10$ipympBl4Ohystqkgu3TLne7CYP8q7G1NhBFCkiVwlzvoPH6rUKaaS',
                'month' => '8',
                'year' => '2022',
                'cvv' => 'eyJpdiI6ImRZUlhoS0lvSzdzNjZwSVwvQnprU0dRPT0iLCJ2YWx1ZSI6IlZKcnVTa0VpU3pRYyt2QW1XREpSbGc9PSIsIm1hYyI6ImI4MGZkYWE0YzQyNGMxMmIwOWQxZjhmNzljNzM1ZDFlMTI5MmFjZDM2MWRlZGQ0MmFjYmM1NjIxODc4ZGU4NmMifQ==',
                'cvv_hash' => '$2y$10$MwpAvgjYqljo5OLyzkUIpe8YnyYaHUuDlgiD.BZ8v7bv1mBKZ/.Bi',
                'is_default' => 0,
            ),
        ));

        
    }
}