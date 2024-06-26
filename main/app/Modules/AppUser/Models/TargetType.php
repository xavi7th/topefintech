<?php

namespace App\Modules\AppUser\Models;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Modules\Admin\Models\ErrLog;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\Savings;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\AppUser\Models\TargetType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Savings[] $savings
 * @property-read int|null $savings_count
 * @method static \Illuminate\Database\Eloquent\Builder|TargetType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TargetType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TargetType query()
 * @method static \Illuminate\Database\Eloquent\Builder|TargetType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TargetType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TargetType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TargetType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TargetType extends Model
{
  protected $fillable = ['name'];

  public function savings()
  {
    return $this->morphMany(Savings::class, 'portfolio');
  }

  static function appUserRoutes()
  {
    Route::group(['namespace' => '\App\Modules\AppUser\Models'], function () {
      Route::get('/target-types', 'TargetType@getTargetTypes');

      Route::post('/target-types/create', 'TargetType@userCreateTargetType')->name('appuser.target_type.create');
    });
  }

  static function adminRoutes()
  {
    Route::get('view-target-types', [self::class, 'adminGetTargetTypes'])->name('admin.manage_target_plans')->defaults('extras', ['icon' => 'far fa-save']);
    Route::post('target-type/create', [self::class, 'adminCreateTargetType'])->name('admin.target.create');
    Route::delete('target-type/{target_type}/delete', [self::class, 'adminDeleteTargetType'])->name('admin.target.delete');
  }

  public function adminCreateTargetType(Request $request)
  {

    if (!$request->name) {
      return generate_422_error('A name is required for the Target Plan');
    }

    if (self::where('name', $request->name)->exists()) {
      return generate_422_error('This Target exists already');
    }

    // $url = request()->file('user_img')->store('public/testimonial_images');
    // $url = str_replace_first('public', '/storage', $url);

    try {
      $target_type = TargetType::create([
        'name' => request('name'),
      ]);
      if ($request->isApi()) return response()->json($target_type, 201);

      return back()->withFlash(['success' => 'Target Plan created']);
    } catch (\Throwable $e) {
      ErrLog::notifySuperAdmin($request->user(), $e, 'Target not created');
      if ($request->isApi())  return response()->json(['rsp' => $e->getMessage()], 500);

      return back()->withFlash(['error' => 'Target not created. Check error logs']);
    }
  }

  public function adminGetTargetTypes(Request $request)
  {
    if ($request->isApi()) return TargetType::all();

    return Inertia::render('Admin,ManageTargetPlans', [
      'target_list' => function () {
        return TargetType::withCount('savings')->get();
      }
    ]);
  }

  public function adminDeleteTargetType(Request $request, self $target_type)
  {
    if ($target_type->savings()->exists()) {
      if ($request->isApi())  return response()->json('Target Plan has active savings and cannot be deleted', 403);
      return back()->withFlash(['error' => 'Target Plan has active savings and cannot be deleted']);
    }

    $target_type->delete();

    if ($request->isApi())  return response()->json([], 204);
    return back()->withFlash(['success' => 'Target Plan deleted']);
  }


  public function getTargetTypes(Request $request)
  {
    return TargetType::all();
  }

  public function userCreateTargetType(Request $request)
  {
    if (!$request->name) {
      return generate_422_error(['name' => 'A name is required for the Target Plan']);
    }

    if (self::where('name', $request->name)->exists()) {
      return generate_422_error('This Target exists already');
    }

    $targetType = TargetType::create(request()->all());

    try {
      if ($request->isApi()) {
        return response()->json(['target_type' => $targetType], 201);
      }

      return back()->withFlash(['success' => 'Target has been created. You can now add a plan to it']);
    } catch (\Throwable $th) {
      return response()->json(['rsp' => $th->getMessage()], 500);
    }
  }
}
