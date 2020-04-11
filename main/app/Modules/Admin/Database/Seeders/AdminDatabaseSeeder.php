<?php

namespace App\Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AdminDatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call(ApiRoutesTableSeeder::class);
		$this->call(AdminsTableSeeder::class);
		$this->call(GosTypesTableSeeder::class);
        $this->call(SavingsTableSeeder::class);
    }
}
