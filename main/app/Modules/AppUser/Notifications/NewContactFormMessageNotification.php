<?php

namespace App\Modules\AppUser\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewContactFormMessageNotification extends Notification implements ShouldQueue
{
  use Queueable;

  protected $requestDetails;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(object $requestDetails)
  {
    $this->requestDetails = $requestDetails;
  }

  /**
   * Get the notification's delivery channels.
   * @return array
   */
  public function via()
  {
    return ['mail'];
  }

  public function toMail(SuperAdmin $superAdmin)
  {

    return (new MailMessage)
      ->subject('New ' . config('app.name') . ' Contact Form Message')
      ->line('Sender Name: ' . $this->requestDetails->first_name . ' ' . $this->requestDetails->last_name)
      ->line('Sender Email: ' . $this->requestDetails->email)
      ->line('Sender Phone: ' . $this->requestDetails->phone)
      ->line('Sender Address: ' . $this->requestDetails->address ?? 'Not supplied')
      ->line('Message: ' . $this->requestDetails->message);
  }

  /**
   * Get the database representation of the notification.
   *
   * @param App\Modules\AppUser\Models\AppUser $user
   */
  public function toDatabase($user)
  {
    return [
      'action' => ''
    ];
  }
}
