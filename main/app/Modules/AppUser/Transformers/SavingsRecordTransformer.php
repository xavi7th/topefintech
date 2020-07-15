<?php

namespace App\Modules\AppUser\Transformers;

use App\Modules\AppUser\Models\Savings;

class SavingsRecordTransformer
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

  private function basic(Savings $savings)
  {
    return [
      'id' => $savings->id,
      'current_balance' => $savings->current_balance,
      'type' => $savings->type,
    ];
  }

  private function forUserDashboard(Savings $savings)
  {
    return [
      'id' => $savings->id,
      'current_balance' => $savings->current_balance,
      'name' => $savings->target_type->name,
      'type' => $savings->type,
      'total_duration' => $savings->total_duration,
      'elapsed_duration' => $savings->elapsed_duration,
      'total_unprocessed_interest_amount' => $savings->total_unprocessed_interest_amount()
    ];
  }

  private function forLiquidatedVault(Savings $savings)
  {
    return [
      'id' => $savings->id,
      'current_balance' => $savings->current_balance,
      'name' => $savings->target_type->name,
      'type' => $savings->type,
      'can_withdraw' => $savings->updated_at->addDays(config('app.liquidated_savings_locktime'))->lte(now()),
      'locktime_countdown' => $savings->updated_at->addDays(config('app.liquidated_savings_locktime'))->diffInDays(now()) + 1
    ];
  }
}
