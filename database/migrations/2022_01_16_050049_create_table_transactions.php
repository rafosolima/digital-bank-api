<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->string('id', 36)->unique();
            $table->string('wallet_id_sended', 36)->index()->nullable();
            $table->string('wallet_id_received', 36)->index()->nullable();
            $table->float('value', 12,2);
            $table->timestamps();

            $table->foreign('wallet_id_sended')
                ->references('id')
                ->on('wallets')
                ->onDelete('cascade');

            $table->foreign('wallet_id_received')
                ->references('id')
                ->on('wallets')
                ->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
