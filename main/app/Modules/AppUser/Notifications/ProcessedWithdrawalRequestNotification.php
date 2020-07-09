<?php

namespace App\Modules\AppUser\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Modules\AppUser\Models\WithdrawalRequest;
use Illuminate\Notifications\Messages\MailMessage;

class ProcessedWithdrawalRequestNotification extends Notification
{
  use Queueable;

  private $withdrawal_request;
  private $notification_msg;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(WithdrawalRequest $withdrawal_request)
  {
    $this->withdrawal_request = $withdrawal_request;

    if (!$withdrawal_request->is_charge_free) {
      $this->notification_msg = 'Your withdrawal request of ' . to_naira($this->withdrawal_request->amount) . ' has been processed and ' . to_naira(($this->withdrawal_request->amount - ($this->withdrawal_request->amount * (config('app.undue_withdrawal_charge_percentage') / 100)))) .
        ' has been transferred to your account on file. You were charged a fee of ' . config('app.undue_withdrawal_charge_percentage') . '% for the transaction. If there are any issues kindly contact us.';
    } else {
      $this->notification_msg = 'Your withdrawal request has been processed and ' . to_naira($this->withdrawal_request->amount) . ' has been transferred to your account on file. If there are any issues kindly contact us.';
    }
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
      ->success()
      ->subject('Withdrawal Approved')
      ->greeting('Hello ' . $appUser->full_name . ',')
      ->line($this->notification_msg)
      ->line('Login to see your new account balance')
      ->action('View Balance', route('appuser.savings', $this->token))
      ->line('Once again, welcome to our community of SmartSavers.')
      ->salutation(new HtmlString('Cheers, <br> Your buddies at ' . config('app.name')));
  }

  /**
   * Get the database representation of the notification.
   */
  public function toDatabase($user)
  {
    return [
      'action' => $this->notification_msg
    ];
  }
}
