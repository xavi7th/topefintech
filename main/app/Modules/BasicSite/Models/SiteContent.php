<?php

namespace App\Modules\BasicSite\Models;

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
       return self::whereType('faqs')->first()->content;
     }

     static function setFAQs(string $content):void
     {
       self::updateOrCreate([
         'name' => 'faqs'
       ],[
         'content' => $content
       ]);
     }

     static function getPrivacy(): string
     {
       return self::whereType('privacy_policy')->first()->content;
     }

     static function setPrivacy(string $content):void
     {
       self::updateOrCreate([
         'name' => 'privacy_policy'
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
    Route::prefix('site-contents/faqs')->name('superadmin.manage_site_contents.')->group(function () {
      Route::get('', [self::class, 'superAdminGetTestimonials'])->name('manage_faqs')->defaults('extras', ['icon' => 'fas fa-wrench']);
      Route::post('create', [self::class, 'createTestimonial'])->name('create')->defaults('extras', ['icon' => 'fas fa-wrench']);
      Route::put('{testimonial}/update', [self::class, 'updateTestimonial'])->name('update')->defaults('extras', ['icon' => 'fas fa-wrench']);
      Route::delete('{testimonial}/delete', [self::class, 'deleteTestimonial'])->name('delete');
    });
  }

}
