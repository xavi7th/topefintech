<?php

namespace App\Modules\Admin\Models;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Modules\Admin\Models\ApiRoute;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\Admin\Transformers\AdminUserTransformer;

class Admin extends User
{
	protected $fillable = [
		'role_id', 'full_name', 'email', 'password', 'phone', 'bvn', 'user_passport', 'gender', 'address', 'dob',
	];
	protected $table = "admins";
	protected $dates = ['dob'];
	const DASHBOARD_ROUTE_PREFIX = 'admin-panel';

	static function canAccess()
	{
		return auth()->user()->isAdmin();
	}

	public function is_verified()
	{
		return $this->verified_at !== null;
	}

	public function permitted_api_routes()
	{
		return $this->belongsToMany(ApiRoute::class, 'api_route_permissions', 'user_id')->withTimestamps();
	}

	static function adminRoutes()
	{
		Route::group(['namespace' => '\App\Modules\Admin\Models'], function () {

			Route::get('/savings', 'Admin@getListOfUserSavings');

			Route::get('admins', 'Admin@getAdmins');

			Route::post('admin/create', 'Admin@createAdmin');

			Route::get('admin/{admin}/permissions', 'Admin@getAdminPermissions');

			Route::put('admin/{admin}/permissions', 'Admin@editAdminPermissions');
		});
	}

	public function getAdmins()
	{
		return (new AdminUserTransformer)->collectionTransformer(Admin::all(), 'transformForAdminViewAdmins');
	}

	public function createAdmin()
	{

		try {
			DB::beginTransaction();
			$admin = Admin::create(Arr::collapse([
				request()->all(),
				[
					'password' => bcrypt('amju@admin'),
					'role_id' => Admin::getAdminId()
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

	public function getAdminPermissions(Admin $admin)
	{
		$permitted_routes = $admin->permitted_api_routes()->get(['api_routes.id'])->map(function ($item, $key) {
			return $item->id;
		});

		$all_routes = ApiRoute::get(['id', 'description'])->map(function ($item, $key) {
			return ['id' => $item->id, 'description' => $item->description];
		});

		return ['permitted_routes' => $permitted_routes, 'all_routes' => $all_routes];
		return (new AdminUserTransformer)->collectionTransformer(Admin::all(), 'transformForAdminViewAdmins');
	}

	public function editAdminPermissions(Admin $admin)
	{
		$admin->permitted_api_routes()->sync(request('permitted_routes'));
		return response()->json(['rsp' => true], 204);
	}
}
