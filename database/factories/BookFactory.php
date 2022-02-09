<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
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
            'isbn' => $this->faker->unique()->isbn13(),
            'year' => $this->faker->year(),
            'price' => $this->faker->randomFloat(2, 0, 1500),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Book $book) {
            $authors = Author::select('id')
                ->inRandomOrder()
                ->limit($this->faker->randomDigitNotNull())
                ->get();
            $book->authors()->attach($authors);
        });
    }
}
