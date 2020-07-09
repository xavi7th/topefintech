<?php

namespace App\Modules\Admin\Notifications;

use Illuminate\Bus\Queueable;
use App\Modules\Admin\Models\Admin;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\HtmlString;

class GenericAdminNotification extends Notification
{
  use Queueable;

  protected $notification;
  protected $subject;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(string $subject, string $notification)
  {
    $this->notification = $notification;
    $this->subject = $subject;
  }

  /**
   * Get the notification's delivery channels.
   * @param App\Modules\Admin\Models\Admin $admin
   *
   * @return array
   */
  public function via(Admin $admin)
  {
    return ['database', 'mail'];
  }

  /**
   * Get the mail representation of the notification.
   * @param App\Modules\Admin\Models\Admin $admin
   *
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail(Admin $admin)
  {

    return (new MailMessage)
      ->subject($this->subject)
      ->greeting('Hello ' . $admin->full_name . ',')
      ->line($this->notification)
      ->salutation(new HtmlString('Cheers, <br>' . config('app.name')));
  }

  /**
   * Get the database representation of the notification.
   *
   * @param App\Modules\Admin\Models\Admin $admin
   */
  public function toDatabase(Admin $admin)
  {

    return [
      'action' => $this->subject . ': ' . $this->notification,

    ];
  }
}
