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
  }
  /**
   * The basic site routes that don't require authentication
   * @return Response
   */
  public static function routes()
  {
    Route::group(['middleware' => 'web', 'namespace' => 'App\\Modules\BasicSite\Http\Controllers'], function () {

      Route::get('/site/setup/{key?}',  function ($key = null) {

        if ($key == config('app.migration_key')) {
          // dd(config('app.migration_key'));

          try {
            echo '<br>init storage:link...';
            $rsp = Artisan::call('storage:link');
            echo 'done storage:link. Result: ' . $rsp;

            echo '<br>init migrate:fresh...';
            $rsp =  Artisan::call('migrate:fresh');
            echo 'done migrate:fresh. Result: ' . $rsp;

            echo '<br>init module:seed...';
            $rsp =  Artisan::call('module:seed');
            echo 'done module:seed. Result: ' . $rsp;
          } catch (Exception $e) {
            Response::make($e->getMessage(), 500);
          }
        } else {
          App::abort(404);
        }
      });

      Route::get('/', [BasicSiteController::class, 'index'])->name('app.home');
      Route::get('/blog', [BasicSiteController::class, 'blog'])->name('app.blog');
      Route::get('/frequently-asked-questions', [BasicSiteController::class, 'faqs'])->name('app.faqs');
      Route::get('/careers', [BasicSiteController::class, 'careers'])->name('app.careers');
      Route::get('/contact-us', [BasicSiteController::class, 'showContactForm'])->name('app.contact_us');
      Route::post('/contact', [BasicSiteController::class, 'sendContactMessage'])->name('app.contact');
    });


    Route::group(['middleware' => 'web', 'prefix' => 'api'], function () {

      Route::get('testimonials', function () {
        $testimonials = Testimonial::all();

        return (new TestimonialTransformer)->collectionTransformer($testimonials, 'transformForHomePage');
      });

      Route::get('team', function () {
        $teams = TeamMember::all();

        return (new TeamMemberTransformer)->collectionTransformer($teams, 'transformForHomePage');
      });

      Route::get('faq', function () {
        // $teams = TeamMember::all();

        // return (new TeamMemberTransformer)->collectionTransformer($teams, 'transformForHomePage');
      });

      Route::post('/contact', function (ContactFormValidation $request) {
        Message::create($request->all());
        return response()->json(['status' => true], 201);
      });
    });
  }

  public function index(Request $request)
  {
    return Inertia::render('HomePage');
  }

  public function blog(Request $request)
  {
    return Inertia::render('OurBlogPage');
  }

  public function faqs(Request $request)
  {
    return Inertia::render('HomePage', [
      'event' => $request->only(
        'id',
        'title',
        'start_date',
        'description'
      ),
    ]);
  }

  public function careers(Request $request)
  {
    return Inertia::render('HomePage', [
      'event' => $request->only(
        'id',
        'title',
        'start_date',
        'description'
      ),
    ]);
  }

  public function showContactForm(Request $request)
  {
    return Inertia::render('HomePage', [
      'event' => $request->only(
        'id',
        'title',
        'start_date',
        'description'
      ),
    ]);
  }

  public function sendContactMessage(Request $request)
  {
    return Inertia::render('HomePage', [
      'event' => $request->only(
        'id',
        'title',
        'start_date',
        'description'
      ),
    ]);
  }
}
