<?php

namespace App\Modules\AppUser\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Modules\AppUser\Models\WithdrawalRequest;
use Illuminate\Notifications\Messages\MailMessage;
use App\Modules\AppUser\Notifications\Channels\BulkSMSMessage;

class ProcessedWithdrawalRequestNotification extends Notification implements ShouldQueue
{
  use Queueable;

  private $withdrawalRequest;
  private $notificationMsg;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(WithdrawalRequest $withdrawalRequest)
  {
    $this->withdrawalRequest = $withdrawalRequest;

    if (!$withdrawalRequest->is_charge_free) {
      $this->notificationMsg = 'Your withdrawal request of ' . to_naira($this->withdrawalRequest->amount) . ' has been processed and ' . to_naira(($this->withdrawalRequest->amount - ($this->withdrawalRequest->amount * (config('app.undue_withdrawal_charge_percentage') / 100)))) .
        ' has been transferred to your account on file. You were charged a fee of ' . config('app.undue_withdrawal_charge_percentage') . '% for the transaction. If there are any issues kindly contact our support team.';
    } else {
      $this->notificationMsg = 'Your withdrawal request has been processed and ' . to_naira($this->withdrawalRequest->amount) . ' has been transferred to your account on file. If there are any issues kindly contact our support team.';
    }
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param AppUser $appUser
   * @return array
   */
  public function via($appUser)
  {
    return [BulkSMSMessage::class, 'database'];
  }

  /**
   * Get the SMS representation of the notification.
   *
   * @param AppUser $appUser
   */
  public function toBulkSMS($appUser)
  {
    return (new BulkSMSMessage)
      ->sms_message($this->notificationMsg)
      ->to($appUser->phone);
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param mixed $appUser
   * @return \Illuminate\Notifications\Messages\MailMessage
   */

  public function toMail(AppUser $appUser)
  {
    return (new MailMessage)
      ->success()
      ->subject('Withdrawal Approved')
      ->greeting('Hello ' . $appUser->full_name . ',')
      ->line($this->notificationMsg)
      ->line('Login to see your new account balance')
      ->action('View Balance', route('appuser.savings', $this->token))
      ->line('Once again, welcome to our community of SmartSavers.')
      ->salutation(new HtmlString('Cheers, <br> Your buddies at ' . config('app.name')));
  }

  /**
   * Get the database representation of the notification.
   */
  public function toDatabase(AppUser $appUser)
  {
    return [
      'action' => $this->notificationMsg
    ];
  }
}
