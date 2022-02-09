<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Disk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Disk>
 */
class DiskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'year' => $this->faker->year(),
            'price' => $this->faker->randomFloat(2, 0, 1500),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Disk $disk) {
            $authors = Author::select('id')
                ->inRandomOrder()
                ->limit($this->faker->randomDigitNotNull())
                ->get();
            $disk->authors()->attach($authors);
        });
    }
}
