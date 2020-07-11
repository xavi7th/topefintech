<?php

namespace App\Modules\AppUser\Notifications;

use Illuminate\Bus\Queueable;
use App\Modules\AppUser\Models\Savings;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TargetSavingsMatured extends Notification
{
  use Queueable;

  private $savings;
  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(Savings $savings)
  {
    $this->savings = $savings;
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
      'action' => 'Congratulations! Your Target savings started with ' . to_naira($this->savings->initial_deposit_transaction->amount) . ' has matured and has been rolled' .
        ' over to your smart savings balance. Over the period you added a total of ' .
        to_naira(value($this->savings->total_deposits_sum() - $this->savings->initial_deposit_transaction->amount)) . ' to this savings portfolio and' .
        ' it accrued a total interest of ' . to_naira($this->savings->total_accrued_interest_amount()) . '.	We hope you are able to use this amount to' .
        ' achieve your intended goal. Keep living, keep saving'
    ];
  }
}
