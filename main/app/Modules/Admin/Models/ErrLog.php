<?php

namespace App\Modules\Admin\Models;

use Error;
use App\User;
use Throwable;
use TypeError;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Admin\Transformers\ErrLogTransformer;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

/**
 * App\Modules\Admin\Models\ErrLog
 *
 * @property int $id
 * @property string|null $message
 * @property string|null $channel
 * @property int $level
 * @property string $level_name
 * @property int $unix_time
 * @property string|null $datetime
 * @property string|null $context
 * @property string|null $extra
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog whereContext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog whereDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog whereLevelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog whereUnixTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ErrLog extends Model
{
  protected $fillable = [];

  static function notifyAdmin(User $user, Throwable $exception, string $message = null)
  {
    // Log::error(json_encode(['userId' => $user->id, 'userType' => get_class($user), 'msg' => $exception->getMessage(), 'context' => $exception]));
    Log::error($message, ['userId' => $user->id, 'userType' => get_class($user), 'msg' => $exception->getMessage(), 'context' => $exception]);
  }

  static function notifyAdminAndFail(User $user, Throwable $exception, string $message = null)
  {
    if (DB::transactionLevel() > 0) {
      Db::rollBack();
    }
    Log::error($message, ['userId' => $user->id, 'userType' => get_class($user), 'msg' => $exception->getMessage(), 'context' => $exception]);
  }

  static function logValidationErrors(Validator $validator, FormRequest $validation_class)
  {
    if (DB::transactionLevel() > 0) {
      Db::rollBack();
    }
    Log::error(get_class($validation_class) . ' validation failed.', ['Data Supplied: ' => $validator->getData(), 'Errors: ' => $validator->errors()->all()]);
  }

  static function apiRoutes()
  {
    Route::group(['namespace' => '\App\Modules\Admin\Models'], function () {
      Route::get('err-logs', 'ErrLog@getErrorLogs')->middleware('auth:admin_api');
    });
  }

  public function getErrorLogs()
  {
    if (auth('admin_api')->check()) {
      return (new ErrLogTransformer)->collectionTransformer(ErrLog::latest()->get(), 'basicTransform');
    }
  }
}
