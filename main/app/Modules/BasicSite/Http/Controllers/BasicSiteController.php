<?php

namespace App\Modules\BasicSite\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Modules\BasicSite\Models\Message;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use App\Modules\BasicSite\Http\Requests\ContactFormValidation;
use App\Modules\AppUser\Notifications\NewContactFormMessageNotification;
use App\Modules\BasicSite\Models\SiteContent;

class BasicSiteController extends Controller
{
  public function __construct()
  {
    $this->middleware('guest')->except(['showContactForm', 'sendContactMessage', 'faqs']);
  }
  /**
   * The basic site routes that don't require authentication
   * @return Response
   */
  public static function routes()
  {
    Route::group(['middleware' => 'web'], function () {
      Route::get('/', [self::class, 'index'])->name('app.home');
      Route::get('/frequently-asked-questions', [self::class, 'faqs'])->name('app.faqs');
      Route::get('/careers', [self::class, 'careers'])->name('app.career')->defaults('extras', ['nav_skip' => true]);
      Route::get('/our-privacy-policy', [self::class, 'showPrivacyPage'])->name('app.privacy')->defaults('extras', ['nav_skip' => true]);
      Route::get('/terms-and-conditions', [self::class, 'showTermsPage'])->name('app.terms')->defaults('extras', ['nav_skip' => true]);
      Route::get('/contact-us', [self::class, 'showContactForm'])->name('app.contact_us');
      Route::post('/contact', [self::class, 'sendContactMessage'])->name('app.contact');
    });
  }

  public function index()
  {
    return Inertia::render('BasicSite,HomePage', [
      'testimonials' => SiteContent::getTestimonialsForHomePage(),
      // 'team_members' => SiteContent::getTeamMembersForHomePage()
    ]);
  }

  public function faqs()
  {
    return Inertia::render('BasicSite,FAQPage');
  }

  public function careers()
  {
    return Inertia::render('BasicSite,CareersPage');
  }

  public function showPrivacyPage()
  {
    return Inertia::render('BasicSite,PrivacyPage',[
      'privacy_policy' => SiteContent::getPrivacyPolicy()
    ]);
  }

  public function showTermsPage()
  {
    return Inertia::render('BasicSite,TermsPage',[
      'terms_of_use' => SiteContent::getTermnsOfUse()
    ]);
  }

  public function showContactForm()
  {
    return Inertia::render('BasicSite,ContactUsPage');
  }

  public function sendContactMessage(ContactFormValidation $request)
  {
    Message::create($request->validated());
    SuperAdmin::find(1)->notify(new NewContactFormMessageNotification((object)$request->validated()));
    if ($request->isApi()) return response()->json(['status' => true], 201);

    return back()->withFlash(['success' => 'Message sent!']);
  }
}
