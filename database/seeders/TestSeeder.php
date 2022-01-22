<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsSeeder::class);

        $commonId = Permission::where('name', 'Common')->first()->id;
        $shopkeeperId = Permission::where('name', 'Shopkeeper')->first()->id;

        $u1 = User::create([
            'name' => 'Pessoa 1',
            'email' => 'pessoa1@gmail.com',
            'cpf_cnpj' => '47723474024',
            'password' => '$2a$12$xBuSlrrfGdiPPB7pK/5Wjupkccfx9CIsZd/r7v89.M5e5qKdrMkQ.',
            'permission_id' => $commonId
        ]);

        $u2 = User::create([
            'name' => 'Loja',
            'email' => 'loja@gmail.com',
            'cpf_cnpj' => '58118466000176',
            'password' => '$2a$12$xBuSlrrfGdiPPB7pK/5Wjupkccfx9CIsZd/r7v89.M5e5qKdrMkQ.',
            'permission_id' => $shopkeeperId
        ]);

        $u3 = User::create([
            'name' => 'Pessoa 2',
            'email' => 'pessoa2@gmail.com',
            'cpf_cnpj' => '28390541084',
            'password' => '$2a$12$xBuSlrrfGdiPPB7pK/5Wjupkccfx9CIsZd/r7v89.M5e5qKdrMkQ.',
            'permission_id' => $commonId
        ]);

        Wallet::create([
            'user_id' => $u1->id,
            'balance' => 1350.99
        ]);
        Wallet::create([
            'user_id' => $u2->id,
            'balance' => 15350.99
        ]);
        Wallet::create([
            'user_id' => $u3->id,
            'balance' => 5350.99
        ]);
    }
}
