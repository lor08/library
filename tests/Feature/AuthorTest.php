<?php

namespace Tests\Feature;

use App\Models\Author;
use Illuminate\Database\Eloquent\Builder;
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

    public function test_top_book_authors()
    {
        $response = $this->getJson("/api/v1/books/top_authors");

        $author = Author::withCount('books')->orderBy('books_count', 'desc')->first();

        $allCount = Author::count();

        $response
            ->assertStatus(200)
            ->assertJsonCount($allCount > 100 ? 100 : $allCount, 'data')
            ->assertJsonFragment([
                'name' => $author->name
            ]);
    }

    public function test_top_disk_authors()
    {
        $response = $this->getJson("/api/v1/disks/top_authors");

        $author = Author::withCount('disks')->orderBy('disks_count', 'desc')->first();

        $allCount = Author::count();

        $response
            ->assertStatus(200)
            ->assertJsonCount($allCount > 100 ? 100 : $allCount, 'data')
            ->assertJsonFragment([
                'name' => $author->name
            ]);
    }

    public function test_counts_books()
    {
        $year = 1999;

        $author = Author::inRandomOrder()->whereHas('books', function (Builder $query) use ($year) {
            $query->where('year', $year);
        })->first();

        $response = $this->postJson("/api/v1/books/count_by_author", [
            'author_name' => $author->name
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'count' => $author->books->where('year', $year)->count(),
                'year' => $year,
            ]);
    }

    public function test_counts_disks()
    {
        $year = 1999;

        $author = Author::inRandomOrder()->whereHas('disks', function (Builder $query) use ($year) {
            $query->where('year', $year);
        })->first();

        $response = $this->postJson("/api/v1/disks/count_by_author", [
            'author_name' => $author->name
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'count' => $author->disks->where('year', $year)->count(),
                'year' => $year,
            ]);
    }
}
