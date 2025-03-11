<?php

namespace Database\Factories;

use App\Models\Destination;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DestinationFactory extends Factory
{

    protected $model = Destination::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->city, // Generates a random city name
            'description' => $this->faker->paragraph, // Generates a random paragraph
            'region' => $this->faker->randomElement(['Europe', 'Asia', 'Africa', 'North America', 'South America', 'Australia']), // Random region
            'lat' => $this->faker->latitude, // Random latitude
            'lng' => $this->faker->longitude, // Random longitude
            'interests' => json_encode($this->faker->randomElements(['beaches', 'hiking', 'history', 'culture', 'adventure', 'food'], 3)), // Random interests
            'image_url' => $this->faker->imageUrl(640, 480, 'city'), // Random image URL
        
        ];
    }
}
