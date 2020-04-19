<?php
namespace App\Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;

class LoanRequestsTableSeeder extends Seeder
{

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{


		\DB::table('loan_requests')->delete();

		\DB::table('loan_requests')->insert(array(
			0 =>
			array(
				'id' => 1,
				'loan_ref' => '0VMMe0OJGuiv',
				'app_user_id' => 2,
				'amount' => 20000.0,
				'expires_at' => '2020-07-18 20:26:35',
				'interest_rate' => 10.0,
				'repayment_installation_duration' => '0',
				'auto_debit' => 0,
				'is_approved' => 0,
				'approved_at' => NULL,
				'approved_by' => NULL,
				'is_disbursed' => 0,
				'is_paid' => 0,
				'paid_at' => NULL,
				'created_at' => '2020-04-18 20:26:35',
				'updated_at' => '2020-04-18 20:26:35',
				'deleted_at' => NULL,
			),
		));
	}
}
