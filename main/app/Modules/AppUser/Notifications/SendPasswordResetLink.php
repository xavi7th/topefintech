<?php

namespace App\Modules\AppUser\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SendPasswordResetLink extends Notification
{
  use Queueable;

  /** @var string $token The verification token */
  private $token;

  public function __construct(string $token)
  {
    $this->token = $token;
  }

  public function via()
  {
    return ['mail'];
  }

  public function toMail(AppUser $appUser)
  {

    return (new MailMessage)
      ->success()
      ->subject('Password Reset')
      ->greeting('Hello ' . $appUser->full_name . ',')
      ->line('You just requested for a password reset.')
      ->line('Kindly click here to reset your password.')
      ->action('Reset Password', route('appuser.password_reset.verify', $this->token))
      ->line('This link will expire in 6 hours time.')
      ->line('If this reset wasn’t initiated by you, kindly log in and change your password to secure your account.')
      ->salutation(new HtmlString('Cheers, <br> Your buddies at ' . config('app.name')));
  }
}
