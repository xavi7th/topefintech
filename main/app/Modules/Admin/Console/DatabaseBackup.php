<?php

namespace App\Modules\Admin\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Modules\SuperAdmin\Models\SuperAdmin;
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

    Storage::makeDirectory('backup/', 0777);

    $command = "mysqldump --user=" . config('database.connections.mysql.username') . " --password=" . config('database.connections.mysql.password') . " --host=" . config('database.connections.mysql.host') . " " . config('database.connections.mysql.database') . "  | gzip > " . storage_path() . "/app/backup/" . $filename;
    $returnVar = NULL;
    $output  = NULL;

    exec($command, $output, $returnVar);

    dump(collect($this->notification)->implode(',' . PHP_EOL));
    SuperAdmin::find(1)->notify(new GenericAdminNotification('Processed database backup', collect($this->notification)->implode(', ' . PHP_EOL)));
  }
}
