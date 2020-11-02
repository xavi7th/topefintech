<?php

namespace App\Modules\AppUser\Transformers;

use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\Transaction;
use App\Modules\AppUser\Models\WithdrawalRequest;

class AppUserTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    try {
      return [
        'total' => $collection->count(),
        'current_page' => $collection->currentPage(),
        'path' => $collection->resolveCurrentPath(),
        'to' => $collection->lastItem(),
        'from' => $collection->firstItem(),
        'last_page' => $collection->lastPage(),
        'next_page_url' => $collection->nextPageUrl(),
        'per_page' => $collection->perPage(),
        'prev_page_url' => $collection->previousPageUrl(),
        'total' => $collection->total(),
        'first_page_url' => $collection->url($collection->firstItem()),
        'last_page_url' => $collection->url($collection->lastPage()),
        'data' => $collection->map(function ($v) use ($transformerMethod) {
          return $this->$transformerMethod($v);
        })
      ];
    } catch (\Throwable $e) {
      return $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
    }
  }

  public function basic(AppUser $user)
  {
    return [
      'email' => (string)$user->email,
      'full_name' => (string)$user->full_name,
    ];
  }

  public function forAgents(AppUser $user)
  {
    return [
      'email' => (string)$user->email,
      'full_name' => (string)$user->full_name,
      'bank' => (string)$user->acc_bank,
      'address' => (string)$user->address,
      'phone' => (string)$user->phone,
      'account_number' => (string)$user->acc_num,
      'total_balance' => (float)$user->total_balance(),
      'total_accrued_interest' => (float)$user->total_interests_amount(),
      'total_withdrawal' => (float)$user->total_withdrawal_amount(),
      'total_deposit' => (float)$user->total_deposit_amount(),
      'num_of_days_active' => (int)$user->activeDays(),
      'is_verified' => (bool)$user->is_verified(),
    ];
  }

  public function detailed(AppUser $user)
  {
    return [
      'id' => (int)$user->id,
      'full_name' => (string)$user->full_name,
      'email' => (string)$user->email,
      'gender' => (string)$user->gender,
      'date_of_birth' => (string)$user->date_of_birth,
      'address' => (string)$user->address,
      'city' => (string)$user->city,
      'country' => (string)$user->country,
      'bank' => (string)$user->acc_bank,
      'account_number' => (string)$user->acc_num,
      'account_name' => (string)$user->acc_name,
      'is_bvn_verified' => (bool)$user->is_bvn_verified,
      'is_bank_verified' => (bool)$user->is_bank_verified,
      'phone' => (string)$user->phone,
      'id_card' => (string)$user->id_card,
      'id_card_thumb_url' => (string)$user->id_card_thumb_url,
      'is_email_verified' => (bool)$user->is_email_verified(),
      'total_deposit' => (float)$user->total_deposit_amount(),
      'total_accrued_interest' => (float)$user->total_interests_amount(),
      'total_withdrawal' => (float)$user->total_withdrawal_amount(),
      'total_balance' => (float)$user->total_balance(),
      'has_smart_savings' => (bool)$user->has_smart_savings(),
      'num_of_days_active' => (int)$user->activeDays()
    ];
  }
}
