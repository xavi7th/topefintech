<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Admin\Models\ApiRoutePermission
 *
 * @property int $id
 * @property int $user_id
 * @property string $user_type
 * @property int $api_route_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ApiRoutePermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ApiRoutePermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ApiRoutePermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ApiRoutePermission whereApiRouteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ApiRoutePermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ApiRoutePermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ApiRoutePermission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ApiRoutePermission whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ApiRoutePermission whereUserType($value)
 * @mixin \Eloquent
 */
class ApiRoutePermission extends Model
{
    protected $fillable = [];
}
