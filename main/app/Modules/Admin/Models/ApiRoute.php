<?php

namespace App\Modules\Admin\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Admin\Models\ApiRoute
 *
 * @property int $id
 * @property string $path
 * @property string $name
 * @property string $meta
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $permitted_users
 * @property-read int|null $permitted_users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ApiRoute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ApiRoute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ApiRoute query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ApiRoute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ApiRoute whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ApiRoute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ApiRoute whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ApiRoute whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ApiRoute wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ApiRoute whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ApiRoute extends Model
{
	protected $fillable = [
		'path', 'name', 'meta',
	];

	public function permitted_users()
	{
		return $this->belongsToMany(User::class, 'api_route_permissions')->withTimestamps();
	}
}
