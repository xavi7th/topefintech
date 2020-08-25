<?php

namespace App\Modules\Agent\Transformers;

use App\Modules\Agent\Models\Agent;

class AgentTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return $collection->map(function ($v) use ($transformerMethod) {
      return $this->$transformerMethod($v);
    });
  }

  public function transform(Agent $user)
  {
    return [
      'name' => $user->name,
    ];
  }

  public function fullTransform(Agent $user)
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
      'date_of_birth' => (string)$user->dob,
      'avatar' => (string)$user->avatar,
      'base_of_operation' => (string)$user->base_of_operation,
      'wallet_balance' => (float)$user->wallet_balance,
      'is_verified' => (bool)$user->is_verified(),
      'is_email_verified' => (bool)$user->is_email_verified(),
      'email_verified_at' => (string)$user->email_verified_at,
      'is_bvn_verified' => (bool)$user->is_bvn_verified,
      'is_bank_verified' => (bool)$user->is_bank_verified,
      'isAgent' => (bool)$user->isAgent(),
    ];
  }
}
