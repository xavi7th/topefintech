<?php

namespace App\Modules\AppUser\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Modules\AppUser\Notifications\Channels\BulkSMSMessage;

class SendAccountVerificationMessage extends Notification implements ShouldQueue
{
  use Queueable;

  private $channel;

  /** @var string $token The verification token */
  private $otp;

  public function __construct($channel = 'sms', string $otp = null)
  {
    $this->otp = $otp;
    $this->channel = $channel;
  }

  public function via()
  {
    if ($this->channel == 'mail') {
      return ['mail'];
    } elseif ($this->channel == 'sms') {
      return [BulkSMSMessage::class];
    } else {
      return ['database'];
    }
  }

  /**
   * Get the database representation of the notification.
   */
  public function toDatabase($user)
  {
    return [
      'action' => (new HtmlString('<b>Welcome to the Smart Monie Community</b>. <br> Thank you for joining Smart Monie. You one stop online Cooperative. <br> Take advantage of our manual and auto saving schemes and get interest to meet your financial needs. <br> Once again, welcome to our community of SmartSavers. <br> <br> Cheers, <br> Your buddies at ' . config('app.name')))
    ];
  }

  /**
   * Get the SMS representation of the notification.
   *
   * @param mixed $app_user
   */
  public function toBulkSMS($app_user)
  {
    return (new BulkSMSMessage)
      ->sms_message('DO NOT DISCLOSE. \n Your ' . config('app.name') . ' OTP for phone number verification is ' . $this->otp . '.')
      ->to($app_user->phone);
  }

  public function toMail(User $appUser)
  {
    return (new MailMessage)
      ->success()
      ->subject('Welcome to the Smart Monie Community')
      ->greeting('Hello ' . $appUser->full_name . ',')
      ->line('Thank you for joining Smart Monie. You one stop online Cooperative.')
      ->line('Take advantage of our manual and auto saving schemes and get interest to meet your financial needs.')
      ->line('Once again, welcome to our community of SmartSavers')
      ->line(new HtmlString('Kindly verify your email by clicking the link below to start saving.'))
      ->action('Verify Email', route('appuser.email.verify', $this->otp))
      ->salutation(new HtmlString('Cheers, <br> Your buddies at ' . config('app.name')));
  }
}
