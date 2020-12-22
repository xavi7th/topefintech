<?php

namespace App\Modules\Admin\Console;

use Illuminate\Console\Command;
use App\Modules\Admin\Models\Admin;
use App\Modules\Admin\Notifications\GenericAdminNotification;

class DatabaseBackup extends Command
{
  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'database:backup';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Backup the database to and SQL file.';
  protected $notification = [];

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {

    $filename = "backup-" . now()->format('Y-m-d') . ".gz";

    $command = "mysqldump --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  | gzip > " . storage_path() . "/app/backup/" . $filename;
    $returnVar = NULL;
    $output  = NULL;

    exec($command, $output, $returnVar);

    dump(collect($this->notification)->implode(',' . PHP_EOL));
    Admin::find(1)->notify(new GenericAdminNotification('Processed database backup', collect($this->notification)->implode(', ' . PHP_EOL)));
  }
}
