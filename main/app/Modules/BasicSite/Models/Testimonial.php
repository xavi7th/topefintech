<?php

namespace App\Modules\BasicSite\Models;

use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
 * @property-read string $thumb_url
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

  protected $appends = ['thumb_url'];

  public function getThumbUrlAttribute(): string
  {
    return Str::of($this->img)->replace(Str::of($this->img)->dirname(), Str::of($this->img)->dirname() . '/thumb');
  }

  static function superAdminRoutes()
  {
    Route::prefix('testimonials')->name('superadmin.testimonial.')->group(function () {
      Route::get('', [self::class, 'superAdminGetTestimonials'])->name('manage_testimonials')->defaults('extras', ['icon' => 'fas fa-comment']);
      Route::post('create', [self::class, 'createTestimonial'])->name('create')->defaults('extras', ['icon' => 'fas fa-comment']);
      Route::put('{testimonial}/update', [self::class, 'updateTestimonial'])->name('update')->defaults('extras', ['icon' => 'fas fa-comment']);
      Route::delete('{testimonial}/delete', [self::class, 'deleteTestimonial'])->name('delete');
    });
  }

  public function superAdminGetTestimonials(Request $request)
  {
    return Inertia::render('SuperAdmin,ManageTestimonials', [
      'testimonials' => self::get(['id', 'name', 'img', 'city', 'testimonial'])
    ]);
  }

  public function createTestimonial(Request $request)
  {
    // dd($request->all());
    $validatedData = $request->validate([
      'name' => ['required', 'unique:testimonials', 'max:50'],
      'city' => ['required', 'max:25'],
      'testimonial' => ['required', 'string'],
      'img' => ['required', 'file', 'image'],
    ], [
      'img.required' => 'Upload an image of the user',
      'img.file' => 'Invalid image',
      'img.image' => 'The user\'s image must be a jpeg, jpg, gif, png, or webm file',
    ]);

    // dd($validatedData);

    self::create([
      'img' => compress_image_upload('img', 'testimonial-images/', 'testimonial-images/thumb/', 1400, true, 150)['img_url'],
      'name' => $validatedData['name'],
      'city' => $validatedData['city'],
      'testimonial' => $validatedData['testimonial'],
    ]);

    return back()->withFlash(['success' => 'Testimonial created. It will be displayed on the home page']);
  }

  public function updateTestimonial(Request $request, self $testimonial)
  {
    $validatedData = $request->validate([
      'name' => ['required', 'unique:testimonials,name,' . $testimonial->name . ',name', 'max:50'],
      'city' => ['required', 'max:25'],
      'testimonial' => ['required', 'string'],
      'img' => ['nullable', 'file', 'image'],
    ], [
      'img.required' => 'Upload an image of the user',
      'img.file' => 'Invalid image',
      'img.image' => 'The user\'s image must be a jpeg, jpg, gif, png, or webm file',
    ]);


    $testimonial->update([
      'name' => $validatedData['name'],
      'city' => $validatedData['city'],
      'testimonial' => $validatedData['testimonial'],
      'img' => $request->img ? compress_image_upload('img', 'testimonial-images/', 'testimonial-images/thumb/', 1400, true, 150)['img_url'] : $testimonial->img
    ]);

    return back()->withFlash(['success' => 'Testimonial update. Changes will will reflect on the home page']);
  }

  public function deleteTestimonial(Request $request, self $testimonial)
  {
    $testimonial->delete();

    return back()->withFlash(['success' => 'Deleted']);
  }


  protected static function boot()
  {
    parent::boot();

    static::saving(function (self $testimonial) {
      $testimonial->country = $testimonial->country ?? 'Nigeria';
    });
  }

}
