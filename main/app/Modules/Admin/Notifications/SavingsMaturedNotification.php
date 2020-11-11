<?php

namespace App\Modules\Admin\Notifications;

use Illuminate\Bus\Queueable;
use App\Modules\AppUser\Models\Savings;
use Illuminate\Notifications\Notification;

class SavingsMaturedNotification extends Notification
{
  use Queueable;

  private $savingsRecord;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(Savings $savingsRecord)
  {
    $this->savingsRecord = $savingsRecord;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param mixed $notifiable
   * @return array
   */
  public function via($savingsRecord)
  {
    return ['database'];
  }


  /**
   * Get the database representation of the notification.
   */
  public function toDatabase()
  {

    return [
      'action' => $this->savingsRecord->app_user->full_name . '´s ' . $this->savingsRecord->portfolio->name . ' savings has matured and is due for payout.'
    ];
  }
}
