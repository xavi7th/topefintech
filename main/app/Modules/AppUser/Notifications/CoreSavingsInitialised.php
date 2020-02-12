<?php

namespace App\Modules\AppUser\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CoreSavingsInitialised extends Notification
{
	use Queueable;

	private $user;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct($user)
	{
		$this->user = $user;
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
	 * Get the database representation of the notification.
	 *
	 * @param App\Modules\CardUser\Models\CardUser $card_user
	 */
	public function toDatabase()
	{

		return [
			'user_name' => $this->user->name,
			'action' => 'A core savings account profile was initialised for you. You can start saving right away from your dashboard.'
		];
	}
}
