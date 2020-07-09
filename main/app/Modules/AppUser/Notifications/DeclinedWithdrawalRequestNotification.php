<?php

namespace App\Modules\AppUser\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DeclinedWithdrawalRequestNotification extends Notification
{
  use Queueable;

  private $amount;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct($amount)
  {
    $this->amount = $amount;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param mixed $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ['database', 'mail'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param mixed $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */

  public function toMail(AppUser $appUser)
  {

    return (new MailMessage)
      ->error()
      ->subject('Withdrawal Request Declined')
      ->greeting('Hello ' . $appUser->full_name . ',')
      ->line('You withdrawal request of ' . to_naira($this->amount) . ' was declined.')
      ->line('Kindly contact support for more information.')
      ->salutation(new HtmlString('Cheers, <br> Your buddies at ' . config('app.name')));
  }

  /**
   * Get the database representation of the notification.
   */
  public function toDatabase($user)
  {
    return [
      'action' => 'Your withdrawal request declined. Kindly contact support for more information.'
    ];
  }
}
