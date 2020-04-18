<?php

namespace App\Modules\BasicSite\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\BasicSite\Models\TeamMember
 *
 * @property int $id
 * @property string $name
 * @property string $position
 * @property string $img
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\TeamMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\TeamMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\TeamMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\TeamMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\TeamMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\TeamMember whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\TeamMember whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\TeamMember wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\TeamMember whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TeamMember extends Model
{
	protected $fillable = [
		'name', 'position', 'img'
	];
}
