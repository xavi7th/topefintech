<?php

namespace App\Modules\Admin\Models;

use App\User;
use Throwable;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use App\Modules\Admin\Transformers\ErrLogTransformer;

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
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereContext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereLevelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereUnixTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ErrLog extends Model
{
  protected $fillable = [];

  static function notifySuperAdmin(User $user, Throwable $exception, string $message = null)
  {
    // Log::error(json_encode(['userId' => $user->id, 'userType' => get_class($user), 'msg' => $exception->getMessage(), 'context' => $exception]));
    Log::error($message, ['userId' => $user->id, 'userType' => get_class($user), 'msg' => $exception->getMessage(), 'context' => $exception]);
  }

  static function notifySuperAdminAndFail(User $user, Throwable $exception, string $message = null)
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

  static function routes()
  {
    Route::get('error-logs', [self::class, 'getErrorLogs'])->name('superadmin.view_errors')->defaults('extras', ['icon' => 'fas fa-code']);
  }

  public function getErrorLogs(Request $request)
  {
    $errors = (new ErrLogTransformer)->collectionTransformer(ErrLog::latest()->get(), 'basicTransform');

    return Inertia::render('SuperAdmin,ErrorLogs', compact('errors'));
  }
}
