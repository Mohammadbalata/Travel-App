<?php

namespace Database\Factories;

use App\Models\Destination;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{

    protected $model = Review::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => "1", 
            'destination_id' => Destination::inRandomOrder()->first()->id,
            'description' => $this->faker->paragraph, 
            'rating' => $this->faker->numberBetween(1, 5),
        ];
    }
}
