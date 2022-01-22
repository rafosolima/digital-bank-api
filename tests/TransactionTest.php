<?php

use App\Models\Wallet;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TransactionTest extends TestCase
{
    use DatabaseMigrations;
    private const URL = 'api/v1/transactions';
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */
    public function emptyBodyTransaction()
    {
        $response = $this->post(self::URL, []);
        $response->assertResponseStatus(422);
        $response->seeJsonStructure([
            'payer',
            'payee',
            'value'
        ]);
    }
    /** @test */
    public function transactionWithNotExisting()
    {
        $response = $this->post(self::URL, [
            "payer" => "ada9d284-d027-4031-94b1-6c78b836619e",
            "payee" => "bbf9d564-d414-1512-78b8-7c625432137e",
            "value" => 10
        ]);
        $response->assertResponseStatus(404);
        $response->seeJsonStructure([
            'code',
            'isSuccess',
            'message'
        ]);
    }
    /** @test */
    public function transferToTwoCommonWallets()
    {
        $walletsCommons = Wallet::factory(2)->create();
        $response = $this->post(self::URL, [
            "payer" => $walletsCommons[0]->id,
            "payee" => $walletsCommons[1]->id,
            "value" => 100
        ]);
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            'code',
            'isSuccess',
            'message'
        ]);
        $this->seeInDatabase('transactions', [
            'wallet_id_sended' => $walletsCommons[0]->id,
            'wallet_id_received' => $walletsCommons[1]->id,
            'value' => 100
        ]);
    }
    /** @test */
    public function transferringFromShopkeeperToCommonWallet()
    {
        $walletsCommons = Wallet::factory(2)->create();
        $permission = $walletsCommons[0]->user->permission;
        $permission->name = 'Shopkeeper';
        $permission->save();
        $response = $this->post(self::URL, [
            "payer" => $walletsCommons[0]->id,
            "payee" => $walletsCommons[1]->id,
            "value" => 100
        ]);
        $response->assertResponseStatus(403);
        $response->seeJsonStructure([
            'code',
            'isSuccess',
            'message'
        ]);
    }
    /** @test */
    public function transferringWalletWithNoBalance()
    {
        $walletsCommons = Wallet::factory(2)->create();
        $walletsCommons[0]->balance = 50;
        $walletsCommons[0]->save();

        $response = $this->post(self::URL, [
            "payer" => $walletsCommons[0]->id,
            "payee" => $walletsCommons[1]->id,
            "value" => 100
        ]);
        $response->assertResponseStatus(500);
        $response->seeJsonStructure([
            'code',
            'isSuccess',
            'message'
        ]);
    }
}
