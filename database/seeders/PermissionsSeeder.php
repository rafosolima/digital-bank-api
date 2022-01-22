<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'id' => Str::uuid()->toString(),
                'name' => 'Common'
            ], [
                'id' => Str::uuid()->toString(),
                'name' => 'Shopkeeper'
            ]
        ];

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission['name'])->first()) {
                Permission::create($permission);
            }
        }
    }
}
