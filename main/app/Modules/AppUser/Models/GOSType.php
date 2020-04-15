<?php

namespace App\Modules\AppUser\Models;


use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\Savings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Modules\Admin\Models\ErrLog;

class GOSType extends Model
{
	protected $fillable = ['name'];
	protected $table = 'gos_types';

	public function savings()
	{
		return $this->hasMany(Savings::class);
	}

	static function appUserApiRoutes()
	{
		Route::group(['namespace' => '\App\Modules\AppUser\Models'], function () {
			Route::get('/gos-types', 'GOSType@getGOSTypes');

			Route::post('/gos-types/create', 'GOSType@userCreateGOSType');
		});
	}


	static function adminApiRoutes()
	{
		Route::group(['namespace' => '\App\Modules\AppUser\Models'], function () {
			Route::get('gos-types', 'GOSType@getGOSTypes');
			Route::post('gos-type/create', 'GOSType@adminCreateGOSType');
			Route::delete('gos-type/{gos_type_id}/delete', 'GOSType@adminDeleteGOSType');
		});
	}


	public function adminCreateGOSType(Request $request)
	{

		if (!$request->name) {
			return generate_422_error(['name' => 'name is requitred']);
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
			return response()->json($gos_type, 201);
		} catch (\Throwable $e) {
			ErrLog::notifyAdmin($request->user(), $e, 'GOS not created');
			return response()->json(['rsp' => $e->getMessage()], 500);
		}
	}

	public function getGOSTypes()
	{
		return GOSType::all();
	}

	public function adminDeleteGOSType($gos_type_id)
	{
		return response()->json(['rsp' => GOSType::destroy($gos_type_id)], 204);
	}



	public function userCreateGOSType(Request $request)
	{
		if (!$request->name) {
			return generate_422_error(['name' => 'name is requitred']);
		}

		if (self::where('name', $request->name)->exists()) {
			return generate_422_error('This GOS exists already');
		}

		try {
			return response()->json(['gos_type' => GOSType::create(request()->all())], 201);
		} catch (\Throwable $th) {
			return response()->json(['rsp' => $th->getMessage()], 500);
		}
	}
}
