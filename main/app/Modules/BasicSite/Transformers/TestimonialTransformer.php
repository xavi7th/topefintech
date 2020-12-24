<?php

namespace App\Modules\BasicSite\Transformers;

use App\Modules\BasicSite\Models\Testimonial;

class TestimonialTransformer
{
	public function collectionTransformer($collection, $transformerMethod)
	{
		return $collection->map(function ($v) use ($transformerMethod) {
			return $this->$transformerMethod($v);
		});
	}

	public function transform(Testimonial $testimonial)
	{
		return [
			'name' => $testimonial->name,
		];
	}

	public function transformForHomePage(Testimonial $testimonial)
	{
		return [
			'name' => (string)$testimonial->name,
			'city' => (string)$testimonial->city,
			'country' => (string)$testimonial->country,
			'thumb_url' => (string)$testimonial->thumb_url,
			'testimonial' => (string)$testimonial->testimonial,
		];
	}
}
