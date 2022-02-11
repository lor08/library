<?php

namespace Tests\Feature;

use App\Http\Resources\BookResource;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_books()
    {
        $response = $this->getJson('/api/v1/books');

        $response->assertStatus(200);
    }

    public function test_create_book()
    {
        $response = $this->postJson('/api/v1/books', [
            "isbn" => 3444434444444,
            "author_name" => "Sergey Lavrov",
            "title" => "Test Book",
            "year" => 1992
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'success' => true
            ]);
    }

    public function test_error_create_book_double_isbn()
    {
        $book = Book::factory()->create();
        $response = $this->postJson('/api/v1/books', [
            "isbn" => $book->isbn,
            "author_name" => "Sergey Lavrov",
            "title" => "Test Book",
            "year" => 1992
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonFragment([
                'message' => "The isbn has already been taken.",
            ]);
    }

    public function test_error_create_book_isbn_is_length()
    {
        $response = $this->postJson('/api/v1/books', [
            "isbn" => 444444,
            "author_name" => "Sergey Lavrov",
            "title" => "Test Book",
            "year" => 1992
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonFragment([
                'message' => "The isbn must be 13 digits.",
            ]);
    }

    public function test_error_create_book_wrong_year()
    {
        $response = $this->postJson('/api/v1/books', [
            "isbn" => 3444434444444,
            "author_name" => "Sergey Lavrov",
            "title" => "Test Book",
            "year" => 20555
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonFragment([
                'message' => "The year must be 4 digits. (and 1 more error)",
            ]);
    }

    public function test_filter_by_year()
    {
        $startYear = 1980;
        $stopYear = 1990;
        $response = $this->getJson("/api/v1/books?start_year=$startYear&stop_year=$stopYear");

        $booksCount = Book::where('year', '>=', $startYear)->where('year', '<=', $stopYear)->count();

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'total' => $booksCount
            ]);
    }
}
