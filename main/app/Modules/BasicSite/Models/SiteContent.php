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

     static function getPrivacyPolicy(): ?string
     {
       return optional(self::whereType('privacy_policy')->first())->content;
     }

     static function setPrivacyPolicy(string $content):void
     {
       self::updateOrCreate([
         'type' => 'privacy_policy'
       ],[
         'content' => $content
       ]);
     }

     static function getTermnsOfUse(): ?string
     {
       return optional(self::whereType('terms_of_use')->first())->content;
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
  }

  public function superAdminGetTermsOfUse(Request $request)
  {
    return Inertia::render('SuperAdmin,ManageTermsOfUse', [
      'terms_of_use' => self::getTermnsOfUse()
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
      'privacy_policy' => self::getPrivacyPolicy()
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


}
