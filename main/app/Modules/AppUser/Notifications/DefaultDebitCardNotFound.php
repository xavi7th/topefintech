<?php

namespace App\Modules\AppUser\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DefaultDebitCardNotFound extends Notification
{
	use Queueable;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct()
	{ }

	/**
	 * Get the notification's delivery channels.
	 * @return array
	 */
	public function via()
	{
		return ['database'];
	}


	/**
	 * Get the database representation of the notification.
	 *
	 * @param App\Modules\AppUser\Models\AppUser $user
	 */
	public function toDatabase($user)
	{
		return [
			'action' => "You have no default debit card specified in your account. Kindly correct this in order for card transactions to proceed smoothly"
		];
	}
}
