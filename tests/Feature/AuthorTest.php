<?php

namespace Tests\Feature;

use App\Models\Author;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use DatabaseTransactions;

    public function test_search_books()
    {
        $authorSuccess = Author::inRandomOrder()->first();
        $authorError = Author::where('id', '!=', $authorSuccess->id)->inRandomOrder()->first();

        $response = $this->postJson("/api/v1/books/search", [
            'author_name' => $authorSuccess->name
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'title' => $authorSuccess->books->first()->title
            ])
            ->assertJsonMissing([
                'title' => $authorError->books->first()->title
            ]);
    }

    public function test_search_disks()
    {
        $authorSuccess = Author::inRandomOrder()->first();
        $authorError = Author::where('id', '!=', $authorSuccess->id)->inRandomOrder()->first();

        $response = $this->postJson("/api/v1/disks/search", [
            'author_name' => $authorSuccess->name
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'title' => $authorSuccess->disks->first()->title
            ])
            ->assertJsonMissing([
                'title' => $authorError->disks->first()->title
            ]);
    }

    public function test_top_authors()
    {
        $response = $this->getJson("/api/v1/top_authors");

        $author = Author::withCount('books')->orderBy('books_count', 'desc')->first();

        $allCount = Author::count();

        $response
            ->assertStatus(200)
            ->assertJsonCount($allCount > 100 ? 100 : $allCount, 'data')
            ->assertJsonFragment([
                'name' => $author->name
            ]);
    }

    public function test_average_counts_books()
    {
//        $authorSuccess = Author::inRandomOrder()->first();
//        $authorError = Author::inRandomOrder()->first();
//
//        $response = $this->postJson("/api/v1/authors/average", [
//            'author_name' => $authorSuccess->name
//        ]);
//
//        $response
//            ->assertStatus(200)
//            ->assertJsonFragment([
//                'title' => $authorSuccess->books->first()->title
//            ])
//            ->assertJsonMissing([
//                'title' => $authorError->books->first()->title
//            ]);
    }
}
