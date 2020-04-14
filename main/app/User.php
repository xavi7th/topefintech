<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Watson\Rememberable\Rememberable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use App\Modules\Admin\Models\ActivityLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Modules\Admin\Models\Admin;

class User extends Authenticatable implements JWTSubject //implements MustVerifyEmail
{
	use Notifiable, SoftDeletes, Rememberable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	public function activities()
	{
		return $this->morphMany(ActivityLog::class, 'user')->latest();
	}



	/**
	 * Returns the dashboard route of the authenticated user
	 *
	 * @return void
	 */
	static function dashboardRoute(): string
	{

		if (Auth::appuser()) {
			return  'appuser.dashboard';
		} else if (Auth::admin()) {
			return 'admin.dashboard';
		} else {
			return route('home');
		}
	}


	/**
	 * Check if the currently authenticated user is an admin
	 *
	 * @return bool
	 */

	public function isAdmin(): bool
	{
		return $this instanceof Admin;
	}

	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = bcrypt($value);
	}

	public function toFlare(): array
	{
		// Only `id` will be sent to Flare.
		return [
			'id' => $this->id
		];
	}

	/**
	 * Get the identifier that will be stored in the subject claim of the JWT.
	 *
	 * @return mixed
	 */
	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Return a key value array, containing any custom claims to be added to the JWT.
	 *
	 * @return array
	 */
	public function getJWTCustomClaims()
	{
		return [];
	}
}
