<?php

namespace App\Modules\AppUser\Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Model;
use App\Modules\AppUser\Models\Transaction;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('users')->delete();

		\DB::table('users')->insert(array(
			0 =>
			array(
				'full_name' => 'Prof. Jasen Funk V',
				'email' => 'dlangworth@example.net',
				'email_verified_at' => '2020-04-11 14:05:59',
				'password' => '$2y$10$5Ajy.V2RQNThYQ/MsPDeGOCOAljVDvVQa1GkLEH7c69bpTaRCFhqi',
				'phone' => '909.360.0503 x620',
				'address' => NULL,
				'city' => NULL,
				'country' => 'Turkmenistan',
				'acc_num' => NULL,
				'acc_bank' => NULL,
				'acc_type' => NULL,
				'bvn' => NULL,
				'is_bvn_verified' => 0,
				'id_card' => '/storage/id_cards/',
				'verified_at' => NULL,
				'can_withdraw' => 0,
				'is_active' => 1,
				'remember_token' => 'z48uUkaWiN',
			),
			1 =>
			array(
				'full_name' => 'Mariane Rempel Sr.',
				'email' => 'xavi7th@gmail.com',
				'email_verified_at' => NULL,
				'password' => '$2y$10$5X1x99sInekDmR2.Fs1dF.oBfbKJoDnmFIpgY4LwENFe9kktItOxu',
				'phone' => NULL,
				'address' => NULL,
				'city' => NULL,
				'country' => 'Nigeria',
				'acc_num' => NULL,
				'acc_bank' => NULL,
				'acc_type' => NULL,
				'bvn' => NULL,
				'is_bvn_verified' => 0,
				'id_card' => NULL,
				'verified_at' => NULL,
				'can_withdraw' => 0,
				'is_active' => 1,
				'remember_token' => NULL,
			),
		));
	}
}
