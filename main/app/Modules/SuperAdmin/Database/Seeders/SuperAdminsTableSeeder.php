<?php

namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\SuperAdmin\Models\SuperAdmin;

class SuperAdminsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    factory(SuperAdmin::class, 1)->create();
  }
}
