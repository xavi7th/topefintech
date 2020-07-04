<?php

namespace App\Modules\BasicSite\Http\Controllers;

use Exception;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Modules\BasicSite\Models\Message;
use App\Modules\AppUser\Models\TeamMember;
use App\Modules\BasicSite\Models\Testimonial;
use App\Modules\BasicSite\Transformers\TeamMemberTransformer;
use App\Modules\BasicSite\Http\Requests\ContactFormValidation;
use App\Modules\BasicSite\Transformers\TestimonialTransformer;

class BasicSiteController extends Controller
{
  public function __construct()
  {
    Inertia::setRootView('basicsite::app');
    $this->middleware('guest')->except(['showContactForm', 'sendContactMessage', 'faqs']);
  }
  /**
   * The basic site routes that don't require authentication
   * @return Response
   */
  public static function routes()
  {
    Route::group(['middleware' => 'web', 'namespace' => 'App\\Modules\BasicSite\Http\Controllers'], function () {
      Route::get('/', [BasicSiteController::class, 'index'])->name('app.home');
      Route::get('/blog', [BasicSiteController::class, 'blog'])->name('app.blog')->defaults('extras', ['nav_skip' => true]);
      Route::get('/frequently-asked-questions', [BasicSiteController::class, 'faqs'])->name('app.faqs');
      Route::get('/careers', [BasicSiteController::class, 'careers'])->name('app.career');
      Route::get('/privacy', [BasicSiteController::class, 'showContactForm'])->name('app.privacy')->defaults('extras', ['nav_skip' => true]);
      Route::get('/terms-and-conditions', [BasicSiteController::class, 'showContactForm'])->name('app.terms')->defaults('extras', ['nav_skip' => true]);
      Route::get('/contact-us', [BasicSiteController::class, 'showContactForm'])->name('app.contact_us');
      Route::post('/contact', [BasicSiteController::class, 'sendContactMessage'])->name('app.contact');
    });
  }

  public function index()
  {
    return Inertia::render('HomePage', [
      // 'testimonials' => (new TestimonialTransformer)->collectionTransformer(Testimonial::all(), 'transformForHomePage'),
      // 'team_members' => (new TeamMemberTransformer)->collectionTransformer(TeamMember::all(), 'transformForHomePage')
    ]);
  }

  public function blog()
  {
    return Inertia::render('OurBlogPage');
  }

  public function faqs()
  {
    return Inertia::render('FAQPage');
  }

  public function careers()
  {
    return Inertia::render('CareersPage');
  }

  public function showContactForm()
  {
    return Inertia::render('ContactUsPage');
  }

  public function sendContactMessage(ContactFormValidation $request)
  {
    Message::create($request->all());
    return response()->json(['status' => true], 201);
  }
}
