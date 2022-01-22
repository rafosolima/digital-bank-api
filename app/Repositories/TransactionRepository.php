<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\Contracts\ITransactionRepository;

class TransactionRepository extends AbstractRepository implements ITransactionRepository
{
    public CONST WITHDRAW = 'WITHDRAW';
    public CONST DEPOSIT = 'DEPOSIT';
    public CONST TRANSACTION = 'TRANSACTION';
    public CONST FAILED = 'FAILED';

	public function __construct(Transaction $model)
	{
		$this->model = $model;
	}
}
