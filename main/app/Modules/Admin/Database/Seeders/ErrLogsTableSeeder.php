<?php
namespace App\Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;

class ErrLogsTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('err_logs')->delete();
  }
}
