<?php

namespace Database\Factories;

use App\Models\Loan;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanFactory extends Factory
{
    protected $model = Loan::class;

    public function definition()
    {
        $random_data = $this->faker->dateTime();
        return [
            'amount' => $this->faker->randomFloat(2, 100, 10000),
            'duration' => $this->faker->numberBetween(6, 24),
            'interest_rate' => $this->faker->randomFloat(2, 3, 10),
            'created_at' => $random_data,
            'updated_at' => $random_data
        ];
    }
}
