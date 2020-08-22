<?php

namespace App\Modules\AppUser\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Modules\AppUser\Notifications\Channels\BulkSMSMessage;

class SendPasswordResetLink extends Notification
{
  use Queueable;

  /** @var string $token The verification token */
  private $otp;

  public function __construct(string $otp)
  {
    $this->otp = $otp;
  }

  public function via()
  {
    return ['mail', BulkSMSMessage::class];
  }

  /**
   * Get the SMS representation of the notification.
   *
   * @param mixed $app_user
   */
  public function toBulkSMS($app_user)
  {
    return (new BulkSMSMessage)
      ->sms_message('DO NOT DISCLOSE. \n Your ' . config('app.name') . ' OTP for password reset is ' . $this->otp . '. If this reset wasn’t initiated by you, kindly log in and change your password to secure your account.')
      ->to($app_user->phone);
  }

  public function toMail(AppUser $appUser)
  {

    return (new MailMessage)
      ->success()
      ->subject('Password Reset')
      ->greeting('Hello ' . $appUser->full_name . ',')
      ->line('You just requested for a password reset.')
      ->line('Kindly click here to reset your password.')
      ->action('Reset Password', route('appuser.password_reset.verify', $this->otp))
      ->line('This link will expire in 6 hours time.')
      ->line('If this reset wasn’t initiated by you, kindly log in and change your password to secure your account.')
      ->salutation(new HtmlString('Cheers, <br> Your buddies at ' . config('app.name')));
  }
}
