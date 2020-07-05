<?php

namespace App\Modules\Admin\Transformers;

use App\User;
use App\Modules\Admin\Models\Admin;

class AdminUserTransformer
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

  public function transformForAdminViewUsers(User $user)
  {
    return [
      'id' => (int)$user->id,
      'full_name' => (string)$user->full_name,
      'email' => (string)$user->email,
      'phone' => (string)$user->phone,
      'gender' => (string)$user->gender,
      'acc_type' => (string)$user->acc_type,
      'acc_num' => (string)$user->acc_num,
      'address' => (string)$user->address,
      'date_of_birth' => (string)$user->date_of_birth,
      'id_card' => (string)$user->id_card,
      'is_verified' => (boolean)$user->is_verified(),
      'is_email_verified' => (boolean)$user->is_email_verified(),
      'email_verified_at' => (string)$user->email_verified_at,
      'is_bvn_verified' => (boolean)$user->is_bvn_verified,
      'is_bank_verified' => (boolean)$user->is_bank_verified,
    ];
  }

  public function transformForAdminViewAdmins(Admin $user)
  {
    return [
      'id' => (int)$user->id,
      'full_name' => (string)$user->full_name,
      'created_at' => (string)$user->created_at,
      'email' => (string)$user->email,
      'id_card' => (string)$user->id_card,
      'is_verified' => (boolean)$user->is_verified(),
      'isAdmin' => (boolean)$user->isAdmin(),
    ];
  }
}
