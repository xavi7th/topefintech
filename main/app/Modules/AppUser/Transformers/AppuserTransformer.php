<?php

namespace App\Modules\AppUser\Transformers;

use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\Transaction;
use App\Modules\AppUser\Models\WithdrawalRequest;

class AppUserTransformer
{
	public function collectionTransformer($collection, $transformerMethod)
	{
		try {
			return [
				'total' => $collection->count(),
				'current_page' => $collection->currentPage(),
				'path' => $collection->resolveCurrentPath(),
				'to' => $collection->lastItem(),
				'from' => $collection->firstItem(),
				'last_page' => $collection->lastPage(),
				'next_page_url' => $collection->nextPageUrl(),
				'per_page' => $collection->perPage(),
				'prev_page_url' => $collection->previousPageUrl(),
				'total' => $collection->total(),
				'first_page_url' => $collection->url($collection->firstItem()),
				'last_page_url' => $collection->url($collection->lastPage()),
				'data' => $collection->map(function ($v) use ($transformerMethod) {
					return $this->$transformerMethod($v);
				})
			];
		} catch (\Throwable $e) {
			return [
				'data' => $collection->map(function ($v) use ($transformerMethod) {
					return $this->$transformerMethod($v);
				})
			];
		}
	}

	public function basic(AppUser $user)
	{
		return [
			'email' => (string)$user->email,
			'name' => (string)$user->name,
		];
	}

	public function detailed(AppUser $user)
	{
		$curr = (function () use ($user) {
			switch ($user->currency) {
				case 'USD':
					return '$';
					break;
				case 'GBP':
					return '£';
					break;
				case 'EUR':
					return '€';
					break;

				default:
					return $user->currency;
					break;
			}
		})();
		return [
			'id' => (int)$user->id,
			'full_name' => (string)$user->name,
			'email' => (string)$user->email,
			'address' => (string)$user->address,
			'city' => (string)$user->city,
			'country' => (string)$user->country,
			'bank' => (string)$user->acc_bank,
			'account_number' => (string)$user->acc_num,
			'is_bvn_verified' => (bool)$user->is_bvn_verified,
			'phone' => (string)$user->phone,
			'id_card' => (string)$user->id_card,
			'is_email_verified' => (boolean)$user->is_email_verified(),
			'total_deposit' => (double)$user->total_deposit_amount(),
			'total_accrued_interest' => (double)$user->total_interests_amount(),
			'total_withdrawal' => (double)$user->total_withdrawal_amount(),
			'total_balance' => (double)$user->total_balance(),
			'total_withdrawable' => (double)$user->total_withdrawable_amount(),
			'has_pending_loan' => (bool)$user->has_pending_loan(),
			'is_loan_surety' => (boolean)$user->is_loan_surety(),
			'num_of_days_active' => (int)$user->activeDays(),
			// 'app_user_category' => (string)$user->app_user_category->category_name,
		];
	}

	public function transformWithdrawalRequest(WithdrawalRequest $wthReq)
	{

		return [
			'id' => (int)$wthReq->id,
			'amount' => (double)$wthReq->amount,
			'payment_option' => (string)$wthReq->payment_option,
			'bitcoin_acc' => (string)$wthReq->bitcoin_acc,
			'receiver_name' => (string)$wthReq->receiver_name,
			'secret_question' => (string)$wthReq->secret_question,
			'secret_answer' => (string)$wthReq->secret_answer,
			'id_type' => (string)$wthReq->id_type,
			'country' => (string)$wthReq->country,
			'acc_name' => (string)$wthReq->acc_name,
			'acc_num' => (string)$wthReq->acc_num,
			'acc_bank' => (string)$wthReq->acc_bank,
			'created_at' => (string)$wthReq->created_at->diffForHumans()
		];
	}

	public function transformProfitTransaction(Transaction $profit)
	{

		return [
			'id' => (int)$profit->id,
			'amount' => (double)$profit->amount,
			'date' => (string)$profit->trans_date->diffForHumans()
		];
	}
	public function transformForProfitChart(AppUser $user)
	{
		$deposits = $user->deposit_transactions()->oldest('trans_date')->get();
		$profits = $user->profit_transactions()->oldest('trans_date')->get();
		$transactions = ($deposits->concat($profits))->sortBy('trans_date')->values();
		// dd($transactions->toArray());

		return $transactions = $transactions->map(function ($item, $key) {
			return [
				'date' => $item->trans_type . ', ' . $item->trans_date->toFormattedDateString(),
				'amount' => $item->amount,
			];
		});

		// return [
		// 	$transactions
		// ];
	}
}
