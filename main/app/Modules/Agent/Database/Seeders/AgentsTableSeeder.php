<?php

namespace App\Modules\Agent\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Agent\Models\Agent;

class AgentsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    factory(Agent::class, 1)->create();
  }
}
