<?php

namespace App\Services;

use App\Repositories\Contracts\ITransactionRepository;
use App\Repositories\Contracts\IWalletRepository;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class TransactionService {

    private $transactionRepository;
    private $walletRepository;

    public function __construct (
        ITransactionRepository $transactionRepository,
        IWalletRepository $walletRepository
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->walletRepository = $walletRepository;
        $this->http = new Client();
    }

    public function withdraw(string $walletIdSended, float $value)
    {
        $fromWallet = $this->walletRepository->find($walletIdSended);
        if (!$fromWallet) {
            return $this->message(404, false, 'Wallet not found');
        }
        $this->walletRepository->withdraw($fromWallet, $value);
        $this->transactionRepository->create([
            'wallet_id_sended' => $walletIdSended,
            'wallet_id_received' => null,
            'value' => $value
        ]);
    }

    public function deposit(string $walletIdReceived, float $value)
    {
        $walletReceived = $this->walletRepository->find($walletIdReceived);
        if (!$walletReceived) {
            return $this->message(404, false, 'Wallet not found');
        }
        $this->walletRepository->deposit($walletReceived, $value);
        $this->transactionRepository->create([
            'wallet_id_sended' => null,
            'wallet_id_received' => $walletIdReceived,
            'value' => $value
        ]);
    }

    public function transfer(
        string $walletIdSended,
        string $walletIdReceived,
        float $value
    )
    {
        try {
            DB::beginTransaction();

            $fromWallet = $this->walletRepository->find($walletIdSended);
            $toWallet = $this->walletRepository->find($walletIdReceived);

            if (!$fromWallet || !$toWallet) {
                throw new Exception('Wallet not found', 404);
            }
            if ($fromWallet->id === $toWallet->id) {
                throw new Exception('You cannot transfer to the same account', 403);
            }
            if ($this->walletRepository->isShopkeeper($fromWallet)) {
                throw new Exception('You are not allowed to transfer', 403);
            }
            if (!$this->walletRepository->withdraw($fromWallet, $value)) {
                throw new Exception('Insufficient balance', 500);
            }
            $this->walletRepository->deposit($toWallet, $value);

            $this->transactionRepository->create([
                'wallet_id_sended' => $walletIdSended,
                'wallet_id_received' => $walletIdReceived,
                'value' => $value
            ]);

            $response = $this->http->get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
            $response = json_decode($response->getBody());
            if ($response->message != 'Autorizado') {
                throw new Exception('Transaction not Allowed', 403);
            }
            DB::commit();
            $this->http->get('http://o4d9z.mocklab.io/notify');
            return $this->message(200, true, 'Transaction successfy');
        } catch (Exception $e) {
            DB::rollback();
            return $this->message($e->getCode(), false, $e->getMessage());
        }
    }

    private function message(int $code, bool $isSucess, string $message) {
        return [
            'code' => $code,
            'isSuccess' => $isSucess,
            'message' => $message
        ];
    }
}
