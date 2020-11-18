<?php

namespace App\Modules\Admin\Transformers;

use App\Modules\Admin\Models\ErrLog;

class ErrLogTransformer
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
				'activities' => $collection->map(function ($v) use ($transformerMethod) {
					return $this->$transformerMethod($v);
				})
			];
		} catch (\Throwable $e) {
      return $collection->map(function ($v) use ($transformerMethod) {
					return $this->$transformerMethod($v);
      });
		}
	}

	public function basicTransform(ErrLog $log)
	{

		return [
			'id' => (int)$log->id,
			'message' => (string)$log->message,
			'type' => (string)$log->level_name,
			'context' => (object)json_decode($log->context),
			'extra' => (string)$log->extra,
			'time' => (string)$log->created_at,
		];
	}
}
