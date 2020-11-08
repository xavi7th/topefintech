<?php

namespace App\Modules\Admin\Transformers;

use App\Modules\AppUser\Models\WithdrawalRequest;


class AdminWithdrawalRequestTransformer
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

  public function detailed(WithdrawalRequest $withdrawalRequest)
  {
    return [
      'id' => (int)$withdrawalRequest->id,
      'description' => (string)$withdrawalRequest->description,
      'amount_requested' => (float)$withdrawalRequest->amount,
      'is_interests' => (bool)$withdrawalRequest->is_interests,
      'is_charge_free' => (bool)$withdrawalRequest->is_charge_free,
      'is_processed' => (bool)$withdrawalRequest->is_processed,
      'is_user_verified' => (bool)$withdrawalRequest->is_user_verified,
      'is_declined' => (bool)$withdrawalRequest->deleted_at,
      'processed_by' => (string)optional($withdrawalRequest->processor)->full_name ?? 'N/A',
      'request_date' => (string)$withdrawalRequest->created_at,
      'user_full_name' => (string)$withdrawalRequest->app_user->full_name,
      'user_email' => (string)$withdrawalRequest->app_user->email,
      'user_phone' => (string)$withdrawalRequest->app_user->phone,
      'user_account_name' => (string)$withdrawalRequest->app_user->acc_name,
      'user_account_number' => (string)$withdrawalRequest->app_user->acc_num,
      'user_account_type' => (string)$withdrawalRequest->app_user->acc_type,
      'user_account_bank' => (string)$withdrawalRequest->app_user->acc_bank,
      'user_smart_collector_full_name' => (string)optional($withdrawalRequest->app_user->smart_collector)->full_name ?? 'N/A',
      'user_smart_collector_phone' => (string)optional($withdrawalRequest->app_user->smart_collector)->phone ?? 'N/A',
      'user_smart_collector_city_of_operation' => (string)optional($withdrawalRequest->app_user->smart_collector)->city_of_operation ?? 'N/A',
      'savings_portfolio_type' => (string)$withdrawalRequest->savingsPortfolio->type,
      'savings_is_liquidated' => (bool)$withdrawalRequest->savingsPortfolio->is_liquidated,
      'savings_start_date' => (string)$withdrawalRequest->savingsPortfolio->funded_at,
      'savings_maturity_date' => (string)$withdrawalRequest->savingsPortfolio->maturity_date,
      'savings_current_balance' => (string)$withdrawalRequest->savingsPortfolio->current_balance,

    ];
  }
}
