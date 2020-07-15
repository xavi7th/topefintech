<?php

namespace App\Modules\AppUser\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WithdrawalRequestCreatedNotification extends Notification
{
  use Queueable;
  private $amount;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(float $amount)
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
    return ['database'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param mixed $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($user)
  {
    return (new MailMessage)
      ->line('The introduction to the notification.')
      ->action('Notification Action', 'https://laravel.com')
      ->line('Thank you for using our application!');
  }

  /**
   * Get the database representation of the notification.
   */
  public function toDatabase($user)
  {
    return [
      'action' => 'Your withdrawal request for ' . $this->amount . ' has been received. We will update you once it has been attended to.'
    ];
  }
}
