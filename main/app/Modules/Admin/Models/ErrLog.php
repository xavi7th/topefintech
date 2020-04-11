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


class ErrLog extends Model
{
	protected $fillable = [];

	static function notifyAdmin(User $user, Throwable $exception, string $message = null)
	{
		Log::error($message, ['userId' => $user->id, 'userType' => get_class($user), 'msg' => $exception->getMessage(), 'context' => $exception]);
	}

	static function notifyAdminAndFail(User $user, Throwable $exception, string $message = null)
	{
		if (DB::transactionLevel() > 0) {
			Db::rollBack();
		}
		Log::error($message, ['userId' => $user->id, 'userType' => get_class($user), 'exception' => $exception]);
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
