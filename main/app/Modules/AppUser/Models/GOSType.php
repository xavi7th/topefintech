<?php

namespace App\Modules\AppUser\Models;


use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\Savings;
use Illuminate\Database\Eloquent\Model;

class GOSType extends Model
{
	protected $fillable = ['name'];
	protected $table = 'gos_types';

	public function savings()
	{
		return $this->hasMany(Savings::class);
	}

	static function appUserRoutes()
	{
		Route::get('/gos-types', function () {
			return GOSType::all();
		});

		Route::post('/gos-types/create', function () {
			try {
				return response()->json(['gos_type' => GOSType::create(request()->all())], 201);
			} catch (\Throwable $th) {
				return response()->json(['rsp' => $th->getMessage()], 500);
			}
		});
	}
}
