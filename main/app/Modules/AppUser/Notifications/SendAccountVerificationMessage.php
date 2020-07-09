<?php

namespace App\Modules\AppUser\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SendAccountVerificationMessage extends Notification
{
  use Queueable;

  private $channel;

  /** @var string $token The verification token */
  private $token;

  public function __construct($channel = 'mail', string $token = null)
  {
    $this->token = $token;
    $this->channel = $channel;
  }

  public function via()
  {
    if ($this->channel == 'mail') {
      return ['mail'];
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
      'action' => (new HtmlString('<b>Welcome to the SmartCoop Community</b>. <br> Thank you for joining SmartCoop. You one stop online Cooperative. <br> Take advantage of our manual and auto saving schemes and get interest to meet your financial needs. <br> You can also take loans and pay over a period of time. <br> Once again, welcome to our community of SmartSavers. <br> <br> Cheers, <br> Your buddies at ' . config('app.name')))
    ];
  }

  public function toMail(User $appUser)
  {

    return (new MailMessage)
      ->success()
      ->subject('Welcome to the SmartCoop Community')
      ->greeting('Hello ' . $appUser->full_name . ',')
      ->line('Thank you for joining SmartCoop. You one stop online Cooperative.')
      ->line('Take advantage of our manual and auto saving schemes and get interest to meet your financial needs.')
      ->line('You can also take loans and pay over a period of time.')
      ->line('Once again, welcome to our community of SmartSavers')
      ->line(new HtmlString('Kindly verify your email by clicking the link below to start saving.'))
      ->action('Verify Email', route('appuser.email.verify', $this->token))
      ->salutation(new HtmlString('Cheers, <br> Your buddies at ' . config('app.name')));
  }
}
