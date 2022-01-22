<?php

namespace App\Repositories\Contracts;

use App\Models\Wallet;

interface IWalletRepository extends IBaseRepository
{
    public function withdraw(Wallet $walletId, float $value) : bool;
    public function deposit(Wallet $walletId, float $value) : bool;
    public function isShopkeeper(Wallet $wallet) : bool;
}
