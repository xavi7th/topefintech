<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Modules\Admin\Models{
/**
 * App\Modules\Admin\Models\ActivityLog
 *
 * @property int $id
 * @property int $user_id
 * @property string $user_type
 * @property string $activity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ActivityLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ActivityLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ActivityLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ActivityLog whereActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ActivityLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ActivityLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ActivityLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ActivityLog whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ActivityLog whereUserType($value)
 * @mixin \Eloquent
 */
	class ActivityLog extends \Eloquent {}
}

namespace App\Modules\Admin\Models{
/**
 * App\Modules\Admin\Models\Admin
 *
 * @property int $id
 * @property int|null $role_id
 * @property string $full_name
 * @property string $email
 * @property string $password
 * @property string|null $phone
 * @property string|null $bvn
 * @property string|null $user_passport
 * @property string|null $gender
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $dob
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Admin\Models\ActivityLog[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Admin\Models\ApiRoute[] $permitted_api_routes
 * @property-read int|null $permitted_api_routes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\WithdrawalRequest[] $processed_withdrawal_requests
 * @property-read int|null $processed_withdrawal_requests_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereBvn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereUserPassport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereVerifiedAt($value)
 * @mixin \Eloquent
 */
	class Admin extends \Eloquent {}
}

namespace App\Modules\Admin\Models{
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
	class ApiRoute extends \Eloquent {}
}

namespace App\Modules\Admin\Models{
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
	class ApiRoutePermission extends \Eloquent {}
}

namespace App\Modules\Admin\Models{
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog whereContext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog whereDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog whereLevelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog whereUnixTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ErrLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class ErrLog extends \Eloquent {}
}

namespace App\Modules\Admin\Models{
/**
 * App\Modules\Admin\Models\ServiceCharge
 *
 * @property int $id
 * @property int $savings_id
 * @property float $amount
 * @property string $description
 * @property bool $is_processed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Modules\AppUser\Models\AppUser $app_user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Admin\Models\ServiceCharge onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge whereIsProcessed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge whereSavingsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Admin\Models\ServiceCharge withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Admin\Models\ServiceCharge withoutTrashed()
 * @mixin \Eloquent
 */
	class ServiceCharge extends \Eloquent {}
}

namespace App\Modules\AppUser\Models{
/**
 * App\Modules\AppUser\Models\AppUser
 *
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $city
 * @property string $country
 * @property string|null $acc_num
 * @property string|null $acc_bank
 * @property string|null $acc_type
 * @property string|null $bvn
 * @property bool $is_bvn_verified
 * @property bool $is_bank_verified
 * @property string|null $id_card
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property bool $can_withdraw
 * @property bool $is_active
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Admin\Models\ActivityLog[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\AutoSaveSetting[] $auto_save_settings
 * @property-read int|null $auto_save_settings_count
 * @property-read \App\Modules\AppUser\Models\Savings $core_savings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\DebitCard[] $debit_cards
 * @property-read int|null $debit_cards_count
 * @property-read \App\Modules\AppUser\Models\DebitCard $default_debit_card
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\Savings[] $gos_savings
 * @property-read int|null $gos_savings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\LoanRequest[] $loan_requests
 * @property-read int|null $loan_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\LoanSurety[] $loan_surety_requests
 * @property-read int|null $loan_surety_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\LoanTransaction[] $loan_transactions
 * @property-read int|null $loan_transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\Savings[] $locked_savings
 * @property-read int|null $locked_savings_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\WithdrawalRequest[] $previous_withdrawal_requests
 * @property-read int|null $previous_withdrawal_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\WithdrawalRequest[] $processed_withdrawal_requests
 * @property-read int|null $processed_withdrawal_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\SavingsInterest[] $savings_interests
 * @property-read int|null $savings_interests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\Savings[] $savings_list
 * @property-read int|null $savings_list_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Admin\Models\ServiceCharge[] $service_charges
 * @property-read int|null $service_charges_count
 * @property-read \App\Modules\AppUser\Models\LoanSurety $surety_request
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\Transaction[] $transactions
 * @property-read int|null $transactions_count
 * @property-read \App\Modules\AppUser\Models\WithdrawalRequest $withdrawal_request
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereAccBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereAccNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereAccType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereBvn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereCanWithdraw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereIdCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereIsBankVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereIsBvnVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereVerifiedAt($value)
 * @mixin \Eloquent
 */
	class AppUser extends \Eloquent {}
}

namespace App\Modules\AppUser\Models{
/**
 * App\Modules\AppUser\Models\AutoSaveSetting
 *
 * @property int $id
 * @property int $app_user_id
 * @property float $amount
 * @property string $period
 * @property int|null $date
 * @property string|null $weekday
 * @property string|null $time
 * @property bool $try_other_cards
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\AppUser\Models\AppUser $app_user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting whereAppUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting whereTryOtherCards($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting whereWeekday($value)
 * @mixin \Eloquent
 */
	class AutoSaveSetting extends \Eloquent {}
}

namespace App\Modules\AppUser\Models{
/**
 * App\Modules\AppUser\Models\DebitCard
 *
 * @property int $id
 * @property int $app_user_id
 * @property string $pan
 * @property string $pan_hash
 * @property string|null $month
 * @property string|null $year
 * @property string|null $cvv
 * @property string|null $cvv_hash
 * @property bool $is_default
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Modules\AppUser\Models\AppUser $app_user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\DebitCard onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereAppUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereCvv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereCvvHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard wherePan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard wherePanHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereYear($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\DebitCard withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\DebitCard withoutTrashed()
 * @mixin \Eloquent
 */
	class DebitCard extends \Eloquent {}
}

namespace App\Modules\AppUser\Models{
/**
 * App\Modules\AppUser\Models\GOSType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\Savings[] $savings
 * @property-read int|null $savings_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\GOSType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\GOSType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\GOSType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\GOSType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\GOSType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\GOSType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\GOSType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class GOSType extends \Eloquent {}
}

namespace App\Modules\AppUser\Models{
/**
 * App\Modules\AppUser\Models\LoanRequest
 *
 * @property int $id
 * @property string $loan_ref
 * @property int $app_user_id
 * @property float $amount
 * @property \Illuminate\Support\Carbon $expires_at
 * @property float $interest_rate
 * @property string $repayment_installation_duration
 * @property bool $auto_debit
 * @property bool $is_approved
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property int|null $approved_by
 * @property bool $is_disbursed
 * @property bool $is_paid
 * @property \Illuminate\Support\Carbon|null $paid_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Modules\AppUser\Models\AppUser $app_user
 * @property-read mixed $auto_refund_settings
 * @property-read mixed $grace_period_expiry
 * @property-read mixed $installments
 * @property-read mixed $is_defaulted
 * @property-read mixed $stakes_for_default
 * @property-read mixed $total_refunded
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\LoanSurety[] $loan_sureties
 * @property-read int|null $loan_sureties_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\LoanTransaction[] $loan_transactions
 * @property-read int|null $loan_transactions_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanRequest newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\LoanRequest onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanRequest query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanRequest whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanRequest whereAppUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanRequest whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanRequest whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanRequest whereAutoDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanRequest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanRequest whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanRequest whereInterestRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanRequest whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanRequest whereIsDisbursed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanRequest whereIsPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanRequest whereLoanRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanRequest wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanRequest whereRepaymentInstallationDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\LoanRequest withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\LoanRequest withoutTrashed()
 * @mixin \Eloquent
 */
	class LoanRequest extends \Eloquent {}
}

namespace App\Modules\AppUser\Models{
/**
 * App\Modules\AppUser\Models\LoanSurety
 *
 * @property int $id
 * @property int $lender_id
 * @property int $surety_id
 * @property int $loan_request_id
 * @property int|null $is_surety_accepted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Modules\AppUser\Models\AppUser $lender
 * @property-read \App\Modules\AppUser\Models\LoanRequest $loan_request
 * @property-read \App\Modules\AppUser\Models\AppUser $surety
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanSurety newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanSurety newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\LoanSurety onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanSurety query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanSurety whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanSurety whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanSurety whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanSurety whereIsSuretyAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanSurety whereLenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanSurety whereLoanRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanSurety whereSuretyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanSurety whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\LoanSurety withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\LoanSurety withoutTrashed()
 * @mixin \Eloquent
 */
	class LoanSurety extends \Eloquent {}
}

namespace App\Modules\AppUser\Models{
/**
 * App\Modules\AppUser\Models\LoanTransaction
 *
 * @property int $id
 * @property int $loan_request_id
 * @property float $amount
 * @property string $trans_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Modules\AppUser\Models\LoanRequest $loan_request
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanTransaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanTransaction whereLoanRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanTransaction whereTransType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanTransaction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class LoanTransaction extends \Eloquent {}
}

namespace App\Modules\AppUser\Models{
/**
 * App\Modules\AppUser\Models\Savings
 *
 * @property int $id
 * @property int $app_user_id
 * @property string $type
 * @property int|null $gos_type_id
 * @property \Illuminate\Support\Carbon|null $maturity_date
 * @property float $current_balance
 * @property \Illuminate\Support\Carbon|null $funded_at
 * @property float $savings_distribution
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Modules\AppUser\Models\AppUser $app_user
 * @property-read \App\Modules\AppUser\Models\GOSType|null $gos_type
 * @property-read \App\Modules\AppUser\Models\Transaction $initial_deposit_transaction
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\SavingsInterest[] $savings_interests
 * @property-read int|null $savings_interests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Admin\Models\ServiceCharge[] $service_charges
 * @property-read int|null $service_charges_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\Transaction[] $transactions
 * @property-read int|null $transactions_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings matured()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\Savings onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings whereAppUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings whereCurrentBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings whereFundedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings whereGosTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings whereMaturityDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings whereSavingsDistribution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\Savings withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\Savings withoutTrashed()
 * @mixin \Eloquent
 */
	class Savings extends \Eloquent {}
}

namespace App\Modules\AppUser\Models{
/**
 * App\Modules\AppUser\Models\SavingsInterest
 *
 * @property int $id
 * @property int $savings_id
 * @property float $amount
 * @property bool $is_cleared
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Modules\AppUser\Models\Savings $savings
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest cleared()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\SavingsInterest onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest uncleared()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest whereIsCleared($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest whereSavingsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\SavingsInterest withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\SavingsInterest withoutTrashed()
 * @mixin \Eloquent
 */
	class SavingsInterest extends \Eloquent {}
}

namespace App\Modules\AppUser\Models{
/**
 * App\Modules\AppUser\Models\Transaction
 *
 * @property int $id
 * @property int $savings_id
 * @property string $trans_type
 * @property float $amount
 * @property string|null $description
 * @property \Illuminate\Support\Carbon $interest_processed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Modules\AppUser\Models\Savings $savings
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction deposit()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\Transaction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction whereInterestProcessedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction whereSavingsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction whereTransType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\Transaction withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction withdrawals()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\Transaction withoutTrashed()
 * @mixin \Eloquent
 */
	class Transaction extends \Eloquent {}
}

namespace App\Modules\AppUser\Models{
/**
 * App\Modules\AppUser\Models\WithdrawalRequest
 *
 * @property int $id
 * @property int $app_user_id
 * @property float|null $amount
 * @property bool $is_processed
 * @property bool $is_charge_free
 * @property int|null $processed_by
 * @property string|null $processor_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Modules\AppUser\Models\AppUser $app_user
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $processor
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\WithdrawalRequest onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest whereAppUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest whereIsChargeFree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest whereIsProcessed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest whereProcessedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest whereProcessorType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\WithdrawalRequest withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\WithdrawalRequest withoutTrashed()
 * @mixin \Eloquent
 */
	class WithdrawalRequest extends \Eloquent {}
}

namespace App\Modules\BasicSite\Models{
/**
 * App\Modules\BasicSite\Models\Message
 *
 * @property int $id
 * @property string $phone
 * @property string $email
 * @property string $subject
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Message query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Message whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Message wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Message whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Message whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Message extends \Eloquent {}
}

namespace App\Modules\BasicSite\Models{
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
	class TeamMember extends \Eloquent {}
}

namespace App\Modules\BasicSite\Models{
/**
 * App\Modules\BasicSite\Models\Testimonial
 *
 * @property int $id
 * @property string $name
 * @property string $city
 * @property string $country
 * @property string $img
 * @property string $testimonial
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Testimonial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Testimonial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Testimonial query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Testimonial whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Testimonial whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Testimonial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Testimonial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Testimonial whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Testimonial whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Testimonial whereTestimonial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\BasicSite\Models\Testimonial whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Testimonial extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $city
 * @property string $country
 * @property string|null $acc_num
 * @property string|null $acc_bank
 * @property string|null $acc_type
 * @property string|null $bvn
 * @property int $is_bvn_verified
 * @property int $is_bank_verified
 * @property string|null $id_card
 * @property string|null $verified_at
 * @property int $can_withdraw
 * @property int $is_active
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Admin\Models\ActivityLog[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\WithdrawalRequest[] $processed_withdrawal_requests
 * @property-read int|null $processed_withdrawal_requests_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBvn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCanWithdraw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIdCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsBankVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsBvnVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereVerifiedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\User withoutTrashed()
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}
