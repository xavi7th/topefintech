<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\User;
use App\Modules\Admin\Models\Admin;
use App\Modules\Agent\Models\Agent;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\SuperAdmin\Models\SuperAdmin;

class SuperAdminUserTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    // return $collection;
    // return [
    // 	'total' => $collection->count(),
    // 	'current_page' => $collection->currentPage(),
    // 	'path' => $collection->resolveCurrentPath(),
    // 	$collection->hasMorePages(),
    // 	'to' => $collection->lastItem(),
    // 	'from' => $collection->firstItem(),
    // 	'last_page' => $collection->lastPage(),
    // 	'next_page_url' => $collection->nextPageUrl(),
    // 	'per_page' => $collection->perPage(),
    // 	'prev_page_url' => $collection->previousPageUrl(),
    // 	'total' => $collection->total(),
    // 	'first_page_url' => $collection->url($collection->firstItem()),
    // 	'last_page_url' => $collection->url($collection->lastPage()),
    // 	$collection->items(),
    // ];
    return $collection->map(function ($v) use ($transformerMethod) {
      return $this->$transformerMethod($v);
    });
  }

  public function transform(AppUser $user)
  {
    return [
      'name' => $user->name,
    ];
  }

  public function transformForSuperAdminViewUsers(User $user)
  {
    return [
      'id' => (int)$user->id,
      'full_name' => (string)$user->full_name,
      'email' => (string)$user->email,
      'phone' => (string)$user->phone,
      'gender' => (string)$user->gender,
      'city' => (string)$user->city,
      'country' => (string)$user->country,
      'acc_type' => (string)$user->acc_type,
      'acc_num' => (string)$user->acc_num,
      'address' => (string)$user->address,
      'date_of_birth' => (string)$user->date_of_birth,
      'id_card' => (string)$user->id_card,
      'id_card_thumb_url' => (string)$user->id_card_thumb_url,
      'is_verified' => (bool)$user->is_verified(),
      'is_email_verified' => (bool)$user->is_email_verified(),
      'email_verified_at' => (string)$user->email_verified_at,
      'is_bvn_verified' => (bool)$user->is_bvn_verified,
      'is_bank_verified' => (bool)$user->is_bank_verified,
      'created_at' => (string)$user->created_at,
      'verified_at' => (string)$user->verified_at,
    ];
  }

  public function transformForSuperAdminViewSuperAdmins(SuperAdmin $user)
  {
    return [
      'id' => (int)$user->id,
      'full_name' => (string)$user->full_name,
      'created_at' => (string)$user->created_at,
      'email' => (string)$user->email,
      'id_card' => (string)$user->id_card,
      'is_verified' => (bool)$user->is_verified(),
      'isAdmin' => (bool)$user->isAdmin(),
    ];
  }

  public function transformForSuperAdminViewAdmins(Admin $user)
  {
    return [
      'id' => (int)$user->id,
      'full_name' => (string)$user->full_name,
      'created_at' => (string)$user->created_at,
      'email' => (string)$user->email,
      'id_card' => (string)$user->id_card,
      'is_verified' => (bool)$user->is_verified(),
      'isAdmin' => (bool)$user->isAdmin(),
    ];
  }

  public function transformForSuperAdminViewAgents(Agent $user)
  {
    return [
      'id' => (int)$user->id,
      'full_name' => (string)$user->full_name,
      'created_at' => (string)$user->created_at,
      'email' => (string)$user->email,
      'phone' => (string)$user->phone,
      'wallet_balance' => (float)$user->wallet_balance,
      'ref_code' => (string)$user->ref_code,
      'city_of_operation' => (string)$user->city_of_operation,
      'avatar' => (string)$user->avatar,
      'is_verified' => (bool)$user->is_verified(),
      'isAgent' => (bool)$user->isAgent(),
    ];
  }
}
