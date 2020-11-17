<?php

namespace App\Modules\AppUser\Notifications;

use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\InvestmentType;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewInvestmentInitialised extends Notification implements ShouldQueue
{
  use Queueable;

  private $investmentPortfolio;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(InvestmentType $investmentPortfolio)
  {
    $this->investmentPortfolio = $investmentPortfolio;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param AppUser $appUser
   * @return array
   */
  public function via($appUser)
  {
    return ['database'];
  }


  /**
   * Get the database representation of the notification.
   *
   * @param AppUser $appUser
   * @return array
   */
  public function toDatabase($appUser)
  {

    return [
      'user_name' => $appUser->name,
      'action' => 'A new ' . $this->investmentPortfolio . ' investment portfolio was initialised for you. You can activate it by adding right away from your dashboard.'
    ];
  }
}
