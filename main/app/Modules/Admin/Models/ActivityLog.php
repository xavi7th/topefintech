<?php

namespace App\Modules\Admin\Models;

use App\Modules\Admin\Models\Admin;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SalesRep\Models\SalesRep;
use App\Modules\CardAdmin\Models\CardAdmin;
use App\Modules\Accountant\Models\Accountant;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use App\Modules\NormalAdmin\Models\NormalAdmin;
use App\Modules\AccountOfficer\Models\AccountOfficer;
use App\Modules\CustomerSupport\Models\CustomerSupport;
use App\Modules\Admin\Transformers\AdminActivityLogTransformer;

/**
 * App\Modules\Admin\Models\ActivityLog
 *
 * @property int $id
 * @property int $user_id
 * @property string $user_type
 * @property string $activity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $user
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereUserType($value)
 * @mixin \Eloquent
 */
class ActivityLog extends Model
{
  protected $fillable = ['activity'];

  public function user()
  {
    return $this->morphTo();
  }

  static function notifyAdmins(string $activity)
  {
    Admin::find(1)->activities()->create([
      'activity' => $activity
    ]);
  }

  static function notifySuperAdmins(string $activity)
  {
    SuperAdmin::find(1)->activities()->create([
      'activity' => $activity
    ]);
  }


  static function adminRoutes()
  {
    Route::group(['namespace' => '\App\Modules\Admin\Models'], function () {
      Route::get('activity-logs', 'ActivityLog@getActivityLogs')->middleware('auth:admin,superadmin');
    });
  }

  public function getActivityLogs()
  {
    if (auth('admin')->check()) {
      return (new AdminActivityLogTransformer)->collectionTransformer(Admin::find(1)->activities, 'basicTransform');
    } else if (auth('superadmin')->check()) {
      return (new AdminActivityLogTransformer)->collectionTransformer(SuperAdmin::find(1)->activities, 'basicTransform');
    }
  }
}
