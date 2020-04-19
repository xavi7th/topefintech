<?php

namespace App\Modules\AppUser\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AutoSaveSavingsFailure extends Notification
{
	use Queueable;

	/** @var float $amount The amount that we tried to deduct from the user's card */
	private $amount;

	/** @var string $failure_reason The reason why the auto save deductiopn failed */
	private $failure_reason;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(float $amount, string $failure_reason)
	{
		$this->amount = $amount;
		$this->failure_reason = $failure_reason;
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
			'action' => "At attempt to automatically save $this->amount based on your auto save setting failed for the following reason: $this->failure_reason"
		];
	}
}
