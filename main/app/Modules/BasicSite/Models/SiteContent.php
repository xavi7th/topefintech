<?php

namespace App\Modules\BasicSite\Models;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\BasicSite\Models\TeamMember;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as TransformedCollection;
use App\Modules\BasicSite\Transformers\TeamMemberTransformer;
use App\Modules\BasicSite\Transformers\TestimonialTransformer;

/**
 * App\Modules\BasicSite\Models\SiteContent
 *
 * @property string $type
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SiteContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiteContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SiteContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|SiteContent whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteContent whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SiteContent whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SiteContent extends Model
{
    protected $fillable = ['type','content'];
     protected $primaryKey = 'type';
     public $incrementing = false;
     protected $keyType = 'string';


     static function getFAQs():string
     {
       return optional(self::whereType('faqs')->first())->content;
     }

     static function setFAQs(string $content):void
     {
       self::updateOrCreate([
         'type' => 'faqs'
       ],[
         'content' => $content
       ]);
     }

     static function getPrivacyPolicy(): self
     {
       return self::whereType('privacy_policy')->firstOrNew();
     }

     static function setPrivacyPolicy(string $content):void
     {
       self::updateOrCreate([
         'type' => 'privacy_policy'
       ],[
         'content' => $content
       ]);
     }

     static function getTermnsOfUse(): self
     {
       return self::whereType('terms_of_use')->firstOrNew();
     }

     static function setTermsOfUse(string $content):void
     {
       self::updateOrCreate([
         'type' => 'terms_of_use'
       ],[
         'content' => $content
       ]);
     }

     static function getTestimonialsForSuperAdmin(): Collection
     {
       return Testimonial::get(['id', 'name', 'img', 'city', 'testimonial']);
     }

     static function getTestimonialsForHomePage(): TransformedCollection
     {
       return (new TestimonialTransformer)->collectionTransformer(Testimonial::all(), 'transformForHomePage');
     }

     static function getTeamMembersForHomePage(): TransformedCollection
     {
       return (new TeamMemberTransformer)->collectionTransformer(TeamMember::all(), 'transformForHomePage');
     }


  static function superAdminRoutes()
  {
    Route::prefix('site-contents/terms-of-use')->name('superadmin.manage_site_contents.terms_of_use')->group(function () {
      Route::get('', [self::class, 'superAdminGetTermsOfUse'])->name('')->defaults('extras', ['icon' => 'fas fa-wrench']);
      Route::post('update', [self::class, 'updateTermsOfUse'])->name('.update');
    });

    Route::prefix('site-contents/privacy-policy')->name('superadmin.manage_site_contents.privacy_policy')->group(function () {
      Route::get('', [self::class, 'superAdminGetPrivacyPolicy'])->name('')->defaults('extras', ['icon' => 'fas fa-wrench']);
      Route::post('update', [self::class, 'updatePrivacyPolicy'])->name('.update');
    });

    Route::prefix('site-contents/embeded-content-image-upload')->name('superadmin.manage_site_contents.')->group(function () {
      Route::post('', [self::class, 'handleContentImageUpload'])->name('image.upload')->defaults('extras', ['icon' => 'fa fa-tachometer-alt']);
    });
  }

  public function superAdminGetTermsOfUse(Request $request)
  {
    return Inertia::render('SuperAdmin,ManageTermsOfUse', [
      'terms_of_use' => self::getTermnsOfUse()->content,
      'csrf_token' => csrf_token()
    ]);
  }

  public function updateTermsOfUse(Request $request)
  {
    $validatedData = $request->validate([
      'terms_of_use' => 'required|string'
    ]);

    self::setTermsOfUse($validatedData['terms_of_use']);

    return back()->withFlash(['success'=> 'Successfully set the terms of use on the site. ']);
  }

  public function superAdminGetPrivacyPolicy(Request $request)
  {
    return Inertia::render('SuperAdmin,ManagePrivacyPolicy', [
      'privacy_policy' => self::getPrivacyPolicy()->content,
      'csrf_token' => csrf_token()
    ]);
  }

  public function updatePrivacyPolicy(Request $request)
  {
    $validatedData = $request->validate([
      'privacy_policy' => 'required|string'
    ]);

    self::setPrivacyPolicy($validatedData['privacy_policy']);

    return back()->withFlash(['success'=> 'Successfully set the privacy policy on the site. ']);
  }


  public function handleContentImageUpload(Request $request)
  {
    $request->validate([
      'upload' => 'required|file|image'
    ]);

    try {
      $urls = compress_image_upload('upload', 'content-images/', 'content-images/thumb/', 1920, true, 300);
    } catch (\Throwable $th) {

      return response()->json([
                "error" => [ "message" => "The image upload failed because " . $th->getMessage() ]
      ], $th->getCode());
    }

    return response()->json(['urls' => [
      'default' => $urls['thumb_url'],
      '300' => $urls['thumb_url'],
      '800' => $urls['img_url'],
      '1200' => $urls['img_url'],
      '1920' => $urls['img_url'],
    ]], 200);
  }


}
