<?php

namespace App\Modules\BasicSite\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\BasicSite\Models\Testimonial
 *
 * @property int $id
 * @property string $name
 * @property string $city
 * @property string $country
 * @property string $img
 * @property string $testimonial
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Testimonial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Testimonial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Testimonial query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Testimonial whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Testimonial whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Testimonial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Testimonial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Testimonial whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Testimonial whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Testimonial whereTestimonial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Testimonial whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Testimonial extends Model
{
	protected $fillable = [
		'name',
		'city',
		'country',
		'img',
		'testimonial',
	];
}
