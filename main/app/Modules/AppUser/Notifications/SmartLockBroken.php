<?php

namespace App\Modules\AppUser\Notifications;

use Illuminate\Bus\Queueable;
use App\Modules\AppUser\Models\Savings;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SmartLockBroken extends Notification
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
			'action' => 'You have chosen to break your smart lock savings started with ' . to_naira($this->savings->initial_deposit_transaction->amount) . '. The amount accrued' .
				' (short the lock break charges) has been rolled over to your core savings balance. We hope the emergency blows over quickly and you can get back' .
				' to saving again. Over the period your smart lock savings accrued a total interest of ' . to_naira($this->savings->total_accrued_interest_amount()) . '. Keep living, keep saving!'
		];
	}
}
