<?php

namespace App\Modules\Admin\Notifications;

use Illuminate\Bus\Queueable;
use App\Modules\AppUser\Models\Savings;
use Illuminate\Notifications\Notification;

class SavingsMaturedNotification extends Notification
{
	use Queueable;

	private $savings_record;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(Savings $savings_record)
	{
		$this->savings_record = $savings_record;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param mixed $notifiable
	 * @return array
	 */
	public function via($savings_record)
	{
		return ['database'];
	}


	/**
	 * Get the database representation of the notification.
	 */
	public function toDatabase()
	{

		return [
			'action' => $this->savings_record->app_user->full_name . '´s ' . $this->savings_record->gos_type->name .
				' savings has matured and ' . $this->savings_record->current_balance . ' been rolled over to his core' .
				' savings account'
		];
	}
}
