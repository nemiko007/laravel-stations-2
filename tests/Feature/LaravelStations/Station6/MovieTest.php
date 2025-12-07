<?php

namespace Tests\Feature\LaravelStations\Station6;

use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;

class MovieTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    #[Group('station6')]
    public function test映画一覧に全ての映画のタイトル、画像URLが表示されているか(): void
    {
        $movies = Movie::factory(12)->create();
        $response = $this->get('/movies');
        $response->assertStatus(200);
        foreach ($movies as $movie) {
            $response->assertSeeText($movie->title);
            $response->assertSee($movie->image_url);
        }
    }
}
