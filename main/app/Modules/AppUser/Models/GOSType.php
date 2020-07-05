<?php

namespace App\Modules\AppUser\Models;


use App\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Modules\Admin\Models\ErrLog;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\Savings;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\AppUser\Models\GOSType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\Savings[] $savings
 * @property-read int|null $savings_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\GOSType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\GOSType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\GOSType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\GOSType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\GOSType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\GOSType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\GOSType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GOSType extends Model
{
  protected $fillable = ['name'];
  protected $table = 'gos_types';

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    if (User::hasRouteNamespace('appuser.')) {
      Inertia::setRootView('appuser::app');
    } elseif (User::hasRouteNamespace('admin.')) {
      Inertia::setRootView('admin::app');
    }
  }

  public function savings()
  {
    return $this->hasMany(Savings::class, 'gos_type_id');
  }

  static function appUserRoutes()
  {
    Route::group(['namespace' => '\App\Modules\AppUser\Models'], function () {
      Route::get('/gos-types', 'GOSType@getGOSTypes');

      Route::post('/gos-types/create', 'GOSType@userCreateGOSType')->name('appuser.gos_type.create');
    });
  }


  static function adminRoutes()
  {
    Route::get('view-gos-types', [self::class, 'adminGetGOSTypes'])->name('admin.manage_gos_plans')->defaults('extras', ['icon' => 'far fa-save']);
    Route::post('gos-type/create', [self::class, 'adminCreateGOSType'])->name('admin.gos.create');
    Route::delete('gos-type/{gos_type}/delete', [self::class, 'adminDeleteGOSType'])->name('admin.gos.delete');
  }



  public function adminCreateGOSType(Request $request)
  {

    if (!$request->name) {
      return generate_422_error('A name is required for the GOS Plan');
    }

    if (self::where('name', $request->name)->exists()) {
      return generate_422_error('This GOS exists already');
    }

    // $url = request()->file('user_img')->store('public/testimonial_images');
    // $url = str_replace_first('public', '/storage', $url);

    try {
      $gos_type = GOSType::create([
        'name' => request('name'),
      ]);
      if ($request->isApi()) return response()->json($gos_type, 201);

      return back()->withSuccess('GOS Plan created');
    } catch (\Throwable $e) {
      ErrLog::notifyAdmin($request->user(), $e, 'GOS not created');
      if ($request->isApi())  return response()->json(['rsp' => $e->getMessage()], 500);

      return back()->withError('GOS not created. Check error logs');
    }
  }

  public function adminGetGOSTypes(Request $request)
  {
    if ($request->isApi()) return GOSType::all();

    return Inertia::render('ManageGOSPlans', [
      'gos_list' => function () {
        return GOSType::withCount('savings')->get();
      }
    ]);
  }

  public function adminDeleteGOSType(Request $request, self $gos_type)
  {
    if ($gos_type->savings()->exists()) {
      if ($request->isApi())  return response()->json('GOS Plan has active savings and cannot be deleted', 403);
      return back()->withError('GOS Plan has active savings and cannot be deleted');
    }

    $gos_type->delete();

    if ($request->isApi())  return response()->json([], 204);
    return back()->withSuccess('GOS Plan deleted');
  }


  public function getGOSTypes(Request $request)
  {
    return GOSType::all();
  }

  public function userCreateGOSType(Request $request)
  {
    if (!$request->name) {
      return generate_422_error(['name' => 'A name is required for the GOS Plan']);
    }

    if (self::where('name', $request->name)->exists()) {
      return generate_422_error('This GOS exists already');
    }

    $gosType = GOSType::create(request()->all());

    try {
      if ($request->isApi()) {
        return response()->json(['gos_type' => $gosType], 201);
      }

      return back()->withSuccess('GOS has been created. You can now add a plan to it');
    } catch (\Throwable $th) {
      return response()->json(['rsp' => $th->getMessage()], 500);
    }
  }
}
