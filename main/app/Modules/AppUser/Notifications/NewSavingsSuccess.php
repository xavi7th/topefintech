<?php

namespace App\Modules\AppUser\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewSavingsSuccess extends Notification
{
  use Queueable;

  /** @var float $amount The amount that we successfully deducted from the user's card */
  private $amount;

  private $type;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(float $amount, string $type = null)
  {
    $this->amount = $amount;
    $this->type = $type;
  }

  /**
   * Get the notification's delivery channels.
   * @return array
   */
  public function via()
  {
    return ['database', 'mail'];
  }

  public function toMail(AppUser $appUser)
  {

    return (new MailMessage)
      ->success()
      ->subject('Payment received ')
      ->greeting('Hello ' . $appUser->full_name . ',')
      ->line('We just received your payment of ' . to_naira($this->amount))
      ->line('To see your new balance login to your account.')
      ->line('Your interest on this deposit has been booked and will start accruing at ' . now()->addDays(config('app.days_before_interest_starts_counting'))->toDateString())
      ->action('View Balance', route('appuser.savings'))
      ->line('Once again, welcome to our community of SmartSavers.')
      ->salutation(new HtmlString('Cheers, <br> Your buddies at ' . config('app.name')));
  }

  /**
   * Get the database representation of the notification.
   *
   * @param App\Modules\AppUser\Models\AppUser $user
   */
  public function toDatabase($user)
  {
    return [
      'action' => 'Congratulations! You just saved ' . to_naira($this->amount) . " into your account."
    ];
  }
}
