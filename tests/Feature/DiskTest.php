<?php

namespace Tests\Feature;

use App\Models\Disk;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DiskTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_all_disks()
    {
        $response = $this->getJson('/api/v1/disks');

        $response->assertStatus(200);
    }

    public function test_create_disk()
    {
        $response = $this->postJson('/api/v1/disks', [
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

    public function test_error_create_disk_without_title()
    {
        $response = $this->postJson('/api/v1/disks', [
            "author_name" => "Sergey Lavrov",
            "year" => 1985
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonFragment([
                'message' => "The title field is required.",
            ]);
    }

    public function test_filter_by_year()
    {
        $startYear = 1980;
        $stopYear = 1990;
        $response = $this->getJson("/api/v1/disks?start_year=$startYear&stop_year=$stopYear");

        $booksCount = Disk::where('year', '>=', $startYear)->where('year', '<=', $stopYear)->count();

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'total' => $booksCount
            ]);
    }
}
