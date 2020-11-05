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

class DeclinedWithdrawalRequestNotification extends Notification implements ShouldQueue
{
  use Queueable;

  private $withdrawalRequest;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(WithdrawalRequest $withdrawalRequest)
  {
    $this->withdrawalRequest = $withdrawalRequest;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param mixed $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return [BulkSMSMessage::class, 'mail'];
  }


  /**
   * Get the SMS representation of the notification.
   *
   * @param AppUser $appUser
   */
  public function toBulkSMS(AppUser $appUser)
  {
    return (new BulkSMSMessage)
      ->sms_message('Your withdrawal request for ' . to_naira($this->withdrawalRequest->amount) . ' has been rejected. Kindly make the request again or contact our support team')
      ->to($appUser->phone);
  }


  /**
   * Get the mail representation of the notification.
   *
   * @param AppUser $appUser
   * @return \Illuminate\Notifications\Messages\MailMessage
   */

  public function toMail(AppUser $appUser)
  {

    return (new MailMessage)
      ->error()
      ->subject('Withdrawal Request Declined')
      ->greeting('Hello ' . $this->withdrawalRequest->app_user->full_name . ',')
      ->line('Your withdrawal request of ' . to_naira($this->withdrawalRequest->amount) . ' was declined.')
      ->line('Kindly contact support for more information or make the request again.')
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
