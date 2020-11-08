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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\WithdrawalRequest[] $processed_withdrawal_requests
 * @property-read int|null $processed_withdrawal_requests_count
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereBvn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUserPassport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereVerifiedAt($value)
 * @mixin \Eloquent
 */
	class Admin extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereContext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereLevelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereUnixTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereUpdatedAt($value)
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
 * @property-read \App\Modules\AppUser\Models\AppUser|null $app_user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Admin\Models\ServiceCharge onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge query()
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

namespace App\Modules\Agent\Models{
/**
 * App\Modules\Agent\Models\Agent
 *
 * @property int $id
 * @property string|null $ref_code
 * @property string $full_name
 * @property string $email
 * @property string $password
 * @property string|null $phone
 * @property string|null $bvn
 * @property string|null $avatar
 * @property string|null $gender
 * @property string|null $address
 * @property string|null $city_of_operation
 * @property \Illuminate\Support\Carbon|null $dob
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Admin\Models\ActivityLog[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Agent\Models\AgentWalletTransaction[] $agent_wallet_transactions
 * @property-read int|null $agent_wallet_transactions_count
 * @property-read float $wallet_balance
 * @property-read \Illuminate\Database\Eloquent\Collection|AppUser[] $managed_users
 * @property-read int|null $managed_users_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\WithdrawalRequest[] $processed_withdrawal_requests
 * @property-read int|null $processed_withdrawal_requests_count
 * @method static \Illuminate\Database\Eloquent\Builder|Agent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Agent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Agent query()
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereBvn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereCityOfOperation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereRefCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agent whereVerifiedAt($value)
 * @mixin \Eloquent
 */
	class Agent extends \Eloquent {}
}

namespace App\Modules\Agent\Models{
/**
 * App\Modules\Agent\Models\AgentWalletTransaction
 *
 * @property int $id
 * @property int $agent_id
 * @property float $amount
 * @property string $trans_type
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Modules\Agent\Models\Agent $agent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction deposits()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction whereAgentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction whereTransType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction withdrawals()
 * @mixin \Eloquent
 */
	class AgentWalletTransaction extends \Eloquent {}
}

namespace App\Modules\AppUser\Models{
/**
 * App\Modules\AppUser\Models\AppUser
 *
 * @property int $id
 * @property string $full_name
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $city
 * @property string $country
 * @property string|null $date_of_birth
 * @property string|null $gender
 * @property string|null $acc_num
 * @property string|null $acc_name
 * @property string|null $acc_bank
 * @property string|null $acc_type
 * @property string|null $paystack_nuban
 * @property string|null $paystack_nuban_name
 * @property string|null $paystack_nuban_bank
 * @property string|null $bvn
 * @property string|null $bvn_name
 * @property bool $is_bvn_verified
 * @property bool $is_bank_verified
 * @property string|null $id_card
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property bool $can_withdraw
 * @property bool $is_active
 * @property int|null $agent_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Admin\Models\ActivityLog[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|AutoSaveSetting[] $auto_save_settings
 * @property-read int|null $auto_save_settings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|DebitCard[] $debit_cards
 * @property-read int|null $debit_cards_count
 * @property-read DebitCard|null $default_debit_card
 * @property-read string $id_card_thumb_url
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\PaystackTransaction[] $paystack_transactions
 * @property-read int|null $paystack_transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|WithdrawalRequest[] $processed_withdrawal_requests
 * @property-read int|null $processed_withdrawal_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|SavingsInterest[] $savings_interests
 * @property-read int|null $savings_interests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Savings[] $savings_list
 * @property-read int|null $savings_list_count
 * @property-read \Illuminate\Database\Eloquent\Collection|ServiceCharge[] $service_charges
 * @property-read int|null $service_charges_count
 * @property-read Agent|null $smart_collector
 * @property-read Savings|null $smart_savings
 * @property-read \Illuminate\Database\Eloquent\Collection|Savings[] $target_savings
 * @property-read int|null $target_savings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Transaction[] $transactions
 * @property-read int|null $transactions_count
 * @property-read WithdrawalRequest|null $withdrawal_request
 * @property-read \Illuminate\Database\Eloquent\Collection|WithdrawalRequest[] $withdrawal_requests
 * @property-read int|null $withdrawal_requests_count
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereAccBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereAccName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereAccNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereAccType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereAgentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereBvn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereBvnName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereCanWithdraw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereIdCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereIsBankVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereIsBvnVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser wherePaystackNuban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser wherePaystackNubanBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser wherePaystackNubanName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereVerifiedAt($value)
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
 * @property \Illuminate\Support\Carbon $processed_at
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting whereProcessedAt($value)
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
 * @property string|null $brand
 * @property string|null $sub_brand
 * @property string|null $country
 * @property string|null $card_type
 * @property string|null $bank
 * @property string $pan
 * @property string $pan_hash
 * @property string|null $month
 * @property string|null $year
 * @property string|null $cvv
 * @property string|null $cvv_hash
 * @property bool $is_default
 * @property bool $is_authorised
 * @property string|null $authorization_code
 * @property object|null $authorization_object
 * @property string $uuid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read AppUser $app_user
 * @property-read mixed $xed_pan
 * @method static \Illuminate\Database\Eloquent\Builder|DebitCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DebitCard newQuery()
 * @method static \Illuminate\Database\Query\Builder|DebitCard onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DebitCard query()
 * @method static \Illuminate\Database\Eloquent\Builder|DebitCard whereAppUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebitCard whereAuthorizationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebitCard whereAuthorizationObject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebitCard whereBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebitCard whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebitCard whereCardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebitCard whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebitCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebitCard whereCvv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebitCard whereCvvHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebitCard whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebitCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebitCard whereIsAuthorised($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebitCard whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebitCard whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebitCard wherePan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebitCard wherePanHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebitCard whereSubBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebitCard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebitCard whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DebitCard whereYear($value)
 * @method static \Illuminate\Database\Query\Builder|DebitCard withTrashed()
 * @method static \Illuminate\Database\Query\Builder|DebitCard withoutTrashed()
 * @mixin \Eloquent
 */
	class DebitCard extends \Eloquent {}
}

namespace App\Modules\AppUser\Models{
/**
 * App\Modules\AppUser\Models\PaystackTransaction
 *
 * @property int $id
 * @property int $app_user_id
 * @property float $amount
 * @property string $description
 * @property string $transaction_reference
 * @property string|null $paystack_response
 * @property int $is_processed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Modules\AppUser\Models\AppUser $app_user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\PaystackTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\PaystackTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\PaystackTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\PaystackTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\PaystackTransaction whereAppUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\PaystackTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\PaystackTransaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\PaystackTransaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\PaystackTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\PaystackTransaction whereIsProcessed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\PaystackTransaction wherePaystackResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\PaystackTransaction whereTransactionReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\PaystackTransaction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class PaystackTransaction extends \Eloquent {}
}

namespace App\Modules\AppUser\Models{
/**
 * App\Modules\AppUser\Models\Savings
 *
 * @property int $id
 * @property int $app_user_id
 * @property string $type
 * @property int|null $target_type_id
 * @property \Illuminate\Support\Carbon|null $maturity_date
 * @property float $current_balance
 * @property \Illuminate\Support\Carbon|null $funded_at
 * @property bool $is_liquidated
 * @property string|null $withdrawn_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read AppUser $app_user
 * @property-read int $elapsed_duration
 * @property-read bool $is_withdrawn
 * @property-read int $total_duration
 * @property-read Transaction|null $initial_deposit_transaction
 * @property-read \Illuminate\Database\Eloquent\Collection|SavingsInterest[] $savings_interests
 * @property-read int|null $savings_interests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|ServiceCharge[] $service_charges
 * @property-read int|null $service_charges_count
 * @property-read TargetType|null $target_type
 * @property-read \Illuminate\Database\Eloquent\Collection|Transaction[] $transactions
 * @property-read int|null $transactions_count
 * @property-read \App\Modules\AppUser\Models\WithdrawalRequest|null $withdrawalRequest
 * @method static \Illuminate\Database\Eloquent\Builder|Savings active()
 * @method static \Illuminate\Database\Eloquent\Builder|Savings liquidated()
 * @method static \Illuminate\Database\Eloquent\Builder|Savings matured()
 * @method static \Illuminate\Database\Eloquent\Builder|Savings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Savings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Savings notWithdrawn()
 * @method static \Illuminate\Database\Query\Builder|Savings onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Savings query()
 * @method static \Illuminate\Database\Eloquent\Builder|Savings whereAppUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Savings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Savings whereCurrentBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Savings whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Savings whereFundedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Savings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Savings whereIsLiquidated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Savings whereMaturityDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Savings whereTargetTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Savings whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Savings whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Savings whereWithdrawnAt($value)
 * @method static \Illuminate\Database\Query\Builder|Savings withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Savings withdrawn()
 * @method static \Illuminate\Database\Query\Builder|Savings withoutTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Savings yieldsInterests()
 * @mixin \Eloquent
 * @property int $interests_withdrawable
 * @method static \Illuminate\Database\Eloquent\Builder|Savings whereInterestsWithdrawable($value)
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
 * @property string|null $description
 * @property string|null $processed_at
 * @property string|null $process_type
 * @property int $is_locked
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Modules\AppUser\Models\Savings $savings
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest compounded()
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest liquidated()
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest locked()
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest newQuery()
 * @method static \Illuminate\Database\Query\Builder|SavingsInterest onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest processed()
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest query()
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest unlocked()
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest unprocessed()
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest whereIsLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest whereProcessType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest whereProcessedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest whereSavingsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|SavingsInterest withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest withdrawn()
 * @method static \Illuminate\Database\Query\Builder|SavingsInterest withoutTrashed()
 */
	class SavingsInterest extends \Eloquent {}
}

namespace App\Modules\AppUser\Models{
/**
 * App\Modules\AppUser\Models\TargetType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Savings[] $savings
 * @property-read int|null $savings_count
 * @method static \Illuminate\Database\Eloquent\Builder|TargetType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TargetType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TargetType query()
 * @method static \Illuminate\Database\Eloquent\Builder|TargetType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TargetType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TargetType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TargetType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class TargetType extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\Transaction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction query()
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
 * @property int $yields_interests
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction whereYieldsInterests($value)
 */
	class Transaction extends \Eloquent {}
}

namespace App\Modules\AppUser\Models{
/**
 * App\Modules\AppUser\Models\WithdrawalRequest
 *
 * @property int $id
 * @property int $app_user_id
 * @property int $savings_id
 * @property float|null $amount
 * @property string|null $description
 * @property bool $is_user_verified
 * @property bool $is_processed
 * @property bool $is_charge_free
 * @property int|null $processed_by
 * @property string|null $processor_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read AppUser $app_user
 * @property-read Model|\Eloquent $processor
 * @property-read Savings $savingsPortfolio
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest newQuery()
 * @method static \Illuminate\Database\Query\Builder|WithdrawalRequest onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest processed()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest unprocessed()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest userUnverified()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest userVerified()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereAppUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereIsChargeFree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereIsProcessed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereIsUserVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereProcessedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereProcessorType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereSavingsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|WithdrawalRequest withTrashed()
 * @method static \Illuminate\Database\Query\Builder|WithdrawalRequest withoutTrashed()
 * @mixin \Eloquent
 * @property int $is_interests
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereIsInterests($value)
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
 * @property string|null $date_of_birth
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDateOfBirth($value)
 */
	class User extends \Eloquent implements \Tymon\JWTAuth\Contracts\JWTSubject {}
}

