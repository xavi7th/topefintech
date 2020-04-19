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
                'id' => 1,
                'app_user_id' => 2,
                'pan' => 'eyJpdiI6IlAwSnM4MUIxSXUzeTRJc1FuTDJnNXc9PSIsInZhbHVlIjoiN2hUMFRQUFoyQVVYOUYwSUU2UGJVN1RzVVIwdEpYNlhCRDA0RFpiNkNkYz0iLCJtYWMiOiJiM2RmNDFhMTI4MDdlMjYyMjBjMWVmYTBkZWQ5ZmE2YTQxZDNlOTZkZmRkODYyM2VkZTc1NGVmMDU0MmE0ZTAyIn0=',
                'pan_hash' => '$2y$10$7R227s5MkKQsd2dJQBCGpOHNtyVIDViitEF2Bx5Sv0y7HANoLzmNu',
                'month' => '8',
                'year' => '2022',
                'cvv' => 'eyJpdiI6ImR0WEc3bUVKeFFSTjFvY2o2bktwckE9PSIsInZhbHVlIjoiZWs0eG8zSnYyRGRjb1VxRCt0Um9IZz09IiwibWFjIjoiMjE1YzI3NDkzNmI5ZjRiZmNkMDY5NTI2ZDNmZWNmOThmOGMyZTdlNmIyZTI0YzU5MmQ5MTFlMmNjM2VjMzlmYSJ9',
                'cvv_hash' => '$2y$10$NNFqe8JlXrOkwTlThfeU8uIjCsXEJODvn9hYQ3VzBo3bFR3h6JoBO',
                'is_default' => 0,
                'created_at' => '2020-04-17 00:00:00',
                'updated_at' => '2020-04-17 00:00:00',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'app_user_id' => 2,
                'pan' => 'eyJpdiI6IjFlVWNiRWMwUmJGQ3lZbjV1NFhpZHc9PSIsInZhbHVlIjoiRU1qVG9uWXU2ZlNqN2l0WEh6ZENmXC9YaldZTlBDS1wvUEthU2NlajdLYzJFPSIsIm1hYyI6IjRhZDFmNzI0ZmUwNDIwYTM0MzMxODBhNmZmYzkwY2E4Y2I4MzgxMDIxNzNkOTViOGFiYWVjNmM4MjQ0Mzk4OTcifQ==',
                'pan_hash' => '$2y$10$kbls1pkDn9T1b1xAPxtD6.0YVSkEdxbfFUq/6hXrcir7QiUWQyWp.',
                'month' => '8',
                'year' => '2022',
                'cvv' => 'eyJpdiI6Im5EK2pYdWxoZmlsV0lDK1FJRkR1SkE9PSIsInZhbHVlIjoicFN4Z2RiYlZKM0FMQ1JLSFA3NnVTUT09IiwibWFjIjoiYzNjOTJhMDAxMDc2N2VhZjYxNTY5MTYwYTE4MmJhMGQ1MzUzYWE1MDdkM2IzOWUxNDMxNjdiYTdiYTE1NzY1YiJ9',
                'cvv_hash' => '$2y$10$VuNlBz1sXs4Tr.PH6HLKyeMmOt406QCCU4PGH8L9P7A4WbCOTwFeq',
                'is_default' => 0,
                'created_at' => '2020-04-15 00:00:00',
                'updated_at' => '2020-04-15 00:00:00',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'app_user_id' => 2,
                'pan' => 'eyJpdiI6IitUUGRRakdITmN1RW8xOE9MNHJza1E9PSIsInZhbHVlIjoiT0p4b2Z5MlViRHNVZW9uOCtxcEdRbGUrUGNrdjNwRTd4SUhXTHdPR0FwWT0iLCJtYWMiOiJmZmJkZWVlODc3NjYzOTEwMGYxMjk0NmUzOWY0YzZmMDlhNDhhMTk2MzE0NTdlZmRiYTdmYjkwZTcyYmJlYzYzIn0=',
                'pan_hash' => '$2y$10$ipympBl4Ohystqkgu3TLne7CYP8q7G1NhBFCkiVwlzvoPH6rUKaaS',
                'month' => '8',
                'year' => '2022',
                'cvv' => 'eyJpdiI6ImRZUlhoS0lvSzdzNjZwSVwvQnprU0dRPT0iLCJ2YWx1ZSI6IlZKcnVTa0VpU3pRYyt2QW1XREpSbGc9PSIsIm1hYyI6ImI4MGZkYWE0YzQyNGMxMmIwOWQxZjhmNzljNzM1ZDFlMTI5MmFjZDM2MWRlZGQ0MmFjYmM1NjIxODc4ZGU4NmMifQ==',
                'cvv_hash' => '$2y$10$MwpAvgjYqljo5OLyzkUIpe8YnyYaHUuDlgiD.BZ8v7bv1mBKZ/.Bi',
                'is_default' => 0,
                'created_at' => '2020-04-14 00:00:00',
                'updated_at' => '2020-04-14 00:00:00',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'app_user_id' => 3,
                'pan' => 'eyJpdiI6IkJtZWRxWkNOb2RnODVOb3h3RE5yNGc9PSIsInZhbHVlIjoiVU9PMFJuVmdnenJlV1VLSFAyQzBMYk1JZ3ZCNUpzM0dtOWVJUFkrRWlYOD0iLCJtYWMiOiJmYjM0ZGNmY2Q4OTYxZjM2ZmVlNGQ4ZDk2MWQ2MTEzNTRkZjA3MzM0MGM0N2NkMmM2OTY5YjEyMGNlOTA0MzE1In0=',
                'pan_hash' => '$2y$10$9UOEoF9IxoA.I79xSCTWtOA6cqh6WW5BKbsChTGxNJ8YI.GMR5Xmu',
                'month' => '4',
                'year' => '2020',
                'cvv' => 'eyJpdiI6InAzNlBJVTl4YUZqcTQwa0ZIbjJFSlE9PSIsInZhbHVlIjoiTmhKcWtxcThIY1hHQnlKUUQxcWd5QT09IiwibWFjIjoiZTE5NWJlM2EzMzFlNDk1ZDBmZjJjYzE0MjE3ZTAzMTdmNmM5ZTk1N2QwMTNiNmI1NGVkMWY4YzBkOTQ5YmU3MiJ9',
                'cvv_hash' => '$2y$10$l6bOAGfdpVd9PnAZiEuDBOzdmIaxy3gRfuZiRxxwuQOyFerMryyam',
                'is_default' => 0,
                'created_at' => '2020-04-18 13:33:21',
                'updated_at' => '2020-04-18 13:33:21',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'app_user_id' => 3,
                'pan' => 'eyJpdiI6ImNOQXpvM3lMYzdFN0xUUmZyQnJrOHc9PSIsInZhbHVlIjoidXRuRVZZTURTUUpsakM5VFNIdndURFBscG5LTkdXb25URFdiUndrVCtNdz0iLCJtYWMiOiJiM2E3NzYzMzI0MjA5ZGE2ZTYxOTQ3NGE4MmE2ZTkzYmYzN2JiMjcwZTlmOGJlNzRmNTFkYzQ5NTA1YzczMzA2In0=',
                'pan_hash' => '$2y$10$CQSDpR6e2kcYXl/mXJwI3eqpBit4aCtaqGqKQ3w0WDla1AwIRP93m',
                'month' => '4',
                'year' => '2020',
                'cvv' => 'eyJpdiI6Im5nN0ZsVUlyZUlLajMyREpqcXNcL0dRPT0iLCJ2YWx1ZSI6IjBsXC9KNVJJTllpMUdBZlwvUDRTM2N1UT09IiwibWFjIjoiN2VhMjQ2ODQ4YTE2ZTU0Njc3ZDVmZjA2ZDMzZGJiNjE3MDc4OWVmN2YwYTlhZjE0MzllNWI3MjRmYWY3ZmVkMCJ9',
                'cvv_hash' => '$2y$10$0QxfhTFz4QwYHi6Gu7A6VuIIp/BrDgBy6pjg.GHeGXOCxhWslcTe2',
                'is_default' => 1,
                'created_at' => '2020-04-18 13:34:43',
                'updated_at' => '2020-04-18 13:34:43',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'app_user_id' => 1,
                'pan' => 'eyJpdiI6ImdxXC9jc0VJa3E0bThYWVlMXC9GaCt6QT09IiwidmFsdWUiOiJ0MmdaOGYxUE12cDhHQVg0SXRoQUZzblRPMTZJNGU5VkVKbXZLSUI5eDZZPSIsIm1hYyI6IjlkZWYzNmEzY2JlNDA4MWZkNGUyM2FiNDc2MzM5NmQ3NGNlOTMzMGMzZTQxZDRjZDI4Njc0YjBhZjM0ZWY4ZTYifQ==',
                'pan_hash' => '$2y$10$/A0xdICjMenQpHhzXTdOTuc.mCmZpN/f04jYLA.an0vfFM/K7n8lG',
                'month' => '4',
                'year' => '2020',
                'cvv' => 'eyJpdiI6ImdOZlZSeHBzWjloVWIrU0hwejNiZVE9PSIsInZhbHVlIjoiM2N6OXlMOExvclwvSGY4RzJaZDYwUWc9PSIsIm1hYyI6IjQ1MDFjNGExNjA5YWQ2NjFkYzRmZTMwOWMxZjVhNTg1MDY1MWEyYmViZDBhYzVjYTgzMmQwYjQ2NThlMTQ2ZDAifQ==',
                'cvv_hash' => '$2y$10$bIwNzAlZFN6GOQJrcAAu3.FyxuSvrFQGdCZ34jW0QMXn.LJ1VPT1u',
                'is_default' => 0,
                'created_at' => '2020-04-18 18:54:34',
                'updated_at' => '2020-04-18 18:54:34',
                'deleted_at' => NULL,
            ),
        ));

        
    }
}