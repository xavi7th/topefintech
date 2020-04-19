<?php
namespace App\Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;

class LoanSuretiesTableSeeder extends Seeder
{

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{


		\DB::table('loan_sureties')->delete();

		\DB::table('loan_sureties')->insert(array(
			0 =>
			array(
				'id' => 1,
				'lender_id' => 2,
				'surety_id' => 1,
				'loan_request_id' => 1,
				'is_surety_accepted' => NULL,
				'created_at' => '2020-04-18 20:26:35',
				'updated_at' => '2020-04-18 20:26:35',
				'deleted_at' => NULL,
			),
			1 =>
			array(
				'id' => 2,
				'lender_id' => 2,
				'surety_id' => 3,
				'loan_request_id' => 1,
				'is_surety_accepted' => NULL,
				'created_at' => '2020-04-18 20:26:35',
				'updated_at' => '2020-04-18 20:26:35',
				'deleted_at' => NULL,
			),
		));
	}
}
