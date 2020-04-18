<?php

namespace App\Modules\Admin\Models;

use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Modules\Admin\Models\ApiRoute;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\BasicSite\Models\Message;
use App\Modules\AppUser\Models\Transaction;
use App\Modules\Admin\Transformers\AdminUserTransformer;
use App\Modules\Admin\Notifications\SavingsMaturedNotification;

class Admin extends User
{
	protected $fillable = [
		'role_id', 'full_name', 'email', 'password', 'phone', 'bvn', 'user_passport', 'gender', 'address', 'dob',
	];
	protected $table = "admins";
	protected $dates = ['dob', 'verified_at'];
	const DASHBOARD_ROUTE_PREFIX = 'admin-panel';

	static function canAccess()
	{
		return auth()->user()->isAdmin();
	}

	public function is_verified()
	{
		return $this->verified_at !== null;
	}

	static function send_notification($notification)
	{
		self::find(1)->notify($notification);
	}

	public function permitted_api_routes()
	{
		return $this->belongsToMany(ApiRoute::class, 'api_route_permissions', 'user_id')->withTimestamps();
	}

	static function adminApiRoutes()
	{
		Route::group(['namespace' => '\App\Modules\Admin\Models'], function () {

			Route::post('test-route-permission', 'Admin@testRoutePermission');

			Route::get('dashboard/statistics', 'Admin@getDashboardStatistics');

			Route::get('/savings', 'Admin@getListOfUserSavings');

			Route::get('admins', 'Admin@getAdmins');

			Route::post('admin/create', 'Admin@createAdmin');

			Route::get('admin/notifications/matured-savings', 'Admin@getMaturedSavingsNotifications');

			Route::get('admin/{admin}/permissions', 'Admin@getAdminPermissions');

			Route::put('admin/{admin}/permissions', 'Admin@editAdminPermissions');
		});
	}

	public function testRoutePermission()
	{
		$api_route = ApiRoute::where('name', request('route'))->first();
		if ($api_route) {
			/**
			 * Give super admin permission to all routes
			 */
			if (Auth::admin()->role_id === 2) {
				return ['rsp' => true];
			}
			return ['rsp'  => $api_route->permitted_users()->where('user_id', auth()->id())->exists()];
		} else {
			return response()->json(['rsp' => false], 410);
		}
	}

	public function getDashboardStatistics()
	{
		return [
			'total_users' => AppUser::count(),
			'total_transactions' => Transaction::where('trans_type', '<>', 'withdrawal')->count(),
			'total_withdrawals' => Transaction::where('trans_type', 'withdrawal')->count(),
			'total_messages' => Message::count(),
		];
	}

	public function getAdmins()
	{
		return (new AdminUserTransformer)->collectionTransformer(self::all(), 'transformForAdminViewAdmins');
	}

	public function createAdmin()
	{

		try {
			DB::beginTransaction();
			$admin = self::create(Arr::collapse([
				request()->all(),
				[
					'password' => bcrypt('amju@admin'),
					'role_id' => self::getAdminId()
				]
			]));
			//Give him access to dashboard
			// TODO set thin when admin fills his details and resets his password
			// $admin->permitted_api_routes()->attach(1);
			DB::commit();
			return response()->json(['rsp' => $admin], 201);
		} catch (\Throwable $e) {
			if (app()->environment() == 'local') {
				return response()->json(['error' => $e->getMessage()], 500);
			}
			return response()->json(['rsp' => 'error occurred'], 500);
		}
	}

	public function getMaturedSavingsNotifications()
	{
		return  self::find(1)->unreadNotifications()->whereType(SavingsMaturedNotification::class)->get();
	}

	public function getAdminPermissions(self $admin)
	{
		$permitted_routes = $admin->permitted_api_routes()->get(['api_routes.id'])->map(function ($item, $key) {
			return $item->id;
		});

		$all_routes = ApiRoute::get(['id', 'description'])->map(function ($item, $key) {
			return ['id' => $item->id, 'description' => $item->description];
		});

		return ['permitted_routes' => $permitted_routes, 'all_routes' => $all_routes];
	}

	public function editAdminPermissions(self $admin)
	{
		$admin->permitted_api_routes()->sync(request('permitted_routes'));
		return response()->json(['rsp' => true], 204);
	}
}
