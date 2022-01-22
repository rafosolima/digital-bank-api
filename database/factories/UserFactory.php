<?php

namespace Database\Factories;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'cpf_cnpj' => rand(10000000000, 99999999999),
            'password' => '$2a$12$xBuSlrrfGdiPPB7pK/5Wjupkccfx9CIsZd/r7v89.M5e5qKdrMkQ.',
            'permission_id' => function() {
                return Permission::factory()->create()->id;
            }
        ];
    }
}
