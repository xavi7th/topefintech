<?php

namespace App\Modules\AppUser\Transformers;

use App\Modules\AppUser\Models\DebitCard;

class SavingsInterestTransformer
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

  public function transformSummary(DebitCard $debitCard)
  {
    return [
      'id' => $debitCard->id,
      'pan' => $debitCard->xed_pan,
      'month' => $debitCard->month,
      'year' => $debitCard->year,
      'is_default' => $debitCard->is_default
    ];
  }
}
