<?php

namespace App\Modules\AppUser\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InvalidSavingsDistributionValue extends Notification
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
			'action' => 'An attempt to process a distributed savings on your account failed because your savings distribution percentage is not 100%. Please fix that and try again.'
		];
	}
}
