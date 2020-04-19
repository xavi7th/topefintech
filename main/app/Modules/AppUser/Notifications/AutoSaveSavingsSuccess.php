<?php

namespace App\Modules\AppUser\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AutoSaveSavingsSuccess extends Notification
{
	use Queueable;

	/** @var float $amount The amount that we successfully deducted from the user's card */
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
			'action' => 'Congratulations! Based on your auto save setting, you have automatically saved ' . to_naira($this->amount) . " according to your savings distribution."
		];
	}
}
