<?php

namespace App\Modules\AppUser\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Modules\AppUser\Models\DebitCard;

class CardDebitSuccess extends Notification
{
	use Queueable;

	/** @var App\Modules\AppUser\Models\DebitCard $debit_card The debit card we attempted to debit */
	private $debit_card;

	/** @var float $amount The amount we attempted to debit */
	private $amount;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(DebitCard $debit_card, float $amount)
	{
		$this->debit_card = $debit_card;
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
			'action' => "There was a successful debit of $this->amount from your card {$this->debit_card->pan}. if you believe this to be in error, kindly contact support."
		];
	}
}
