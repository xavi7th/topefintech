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
  }
}
