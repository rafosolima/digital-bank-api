<?php

namespace App\Repositories;

use App\Models\Wallet;
use App\Repositories\Contracts\IWalletRepository;

class WalletRepository extends AbstractRepository implements IWalletRepository
{
	public function __construct(Wallet $model)
	{
		$this->model = $model;
	}

    public function withdraw(Wallet $wallet, float $value) : bool
    {
        $balance = $wallet->balance - $value;
        if ($balance > 0) {
            $wallet->balance = $balance;
            $wallet->save();
            return true;
        }
        return false;
    }

    public function deposit(Wallet $wallet, float $value) : bool
    {
        $wallet->balance = $wallet->balance + $value;
        $wallet->save();
        return true;
    }

    public function isShopkeeper(Wallet $wallet) : bool
    {
        return $wallet->user->permission->name === 'Shopkeeper';
    }
}
