<?php

namespace App\Modules\AppUser\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Modules\AppUser\Models\WithdrawalRequest;

class ProcessedWithdrawalRequestNotification extends Notification
{
	use Queueable;

	private $withdrawal_request;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(WithdrawalRequest $withdrawal_request)
	{
		$this->withdrawal_request = $withdrawal_request;
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
		if (!$this->withdrawal_request->is_charge_free) {
			return [
				'action' => 'Your withdrawal request of ' . to_naira($this->withdrawal_request->amount) . ' has been processed and ' . to_naira(($this->withdrawal_request->amount - ($this->withdrawal_request->amount * (config('app.undue_withdrawal_charge_percentage') / 100)))) .
					' has been transferred to your account on file. You were charged a fee of ' . config('app.undue_withdrawal_charge_percentage') . '% for the transaction. If there are any issues kindly contact us.'
			];
		} else {
			return [
				'action' => 'Your withdrawal request has been processed and ' . to_naira($this->withdrawal_request->amount) . ' has been transferred to your account on file. If there are any issues kindly contact us.'
			];
		}
	}
}
