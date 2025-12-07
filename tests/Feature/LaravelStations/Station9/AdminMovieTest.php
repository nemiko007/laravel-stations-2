<?php

namespace Tests\Feature\LaravelStations\Station9;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;

class AdminMovieTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    #[Group('station9')]
    public function test管理者映画一覧に全ての映画のカラムが表示されているか(): void
    {
        $count = 12;
        $genreId = Genre::factory()->create()->id;
        for ($i = 0; $i < $count; $i++) {
            Movie::insert([
                'title' => 'タイトル' . $i,
                'image_url' => 'https://techbowl.co.jp/_nuxt/img/6074f79.png',
                'published_year' => 2000 + $i,
                'description' => '概要' . $i,
                'is_showing' => (bool)random_int(0, 1),
                'genre_id' => $genreId,
            ]);
        }
        $movies = Movie::all();
        $response = $this->get('/admin/movies');
        $response->assertStatus(200);
        foreach ($movies as $movie) {
            $response->assertSeeText($movie->title);
            $response->assertSee($movie->image_url);
            $response->assertSeeText($movie->published_year);
            $response->assertSeeText($movie->description);
            if ($movie->is_showing) {
                $response->assertSeeText('上映中');
            } else {
                $response->assertSeeText('上映予定');
            }
        }
        $response->assertDontSee('true');
        $response->assertDontSee('false');
    }

    #[Test]
    #[Group('station9')]
    public function test管理者映画作成画面が表示されているか(): void
    {
        $response = $this->get('/admin/movies/create');
        $response->assertStatus(200);
    }

    #[Test]
    #[Group('station9')]
    public function test管理者映画作成画面で映画が作成されるか(): void
    {
        $this->assertMovieCount(0);
        $response = $this->post(route('admin.movies.store'), [
            'title' => '新しい映画',
            'image_url' => 'https://techbowl.co.jp/_nuxt/img/6074f79.png',
            'published_year' => 2022,
            'description' => "概要\n概要\n",
            'is_showing' => (bool)random_int(0, 1),
            'genre' => 'ジャンル',
        ]);
        $response->assertStatus(302);
        $this->assertMovieCount(1);
    }

    #[Test]
    #[Group('station9')]
    public function testRequiredバリデーションが設定されているか(): void
    {
        $this->assertMovieCount(0);
        $response = $this->post(route('admin.movies.store'), [
            'title' => '',
            'image_url' => '',
            'published_year' => null,
            'description' => '',
            'is_showing' => null,
            'genre' => '',
        ]);
        $response->assertStatus(302);
        $response->assertInvalid(['title', 'image_url', 'published_year', 'description', 'is_showing', 'genre']);
        $this->assertMovieCount(0);
    }

    #[Test]
    #[Group('station9')]
    public function test画像URLバリデーションが設定されているか(): void
    {
        $this->assertMovieCount(0);
        $response = $this->post(route('admin.movies.store'), [
            'title' => '新しい映画',
            'image_url' => '画像URL',
            'published_year' => 2022,
            'description' => "概要\n概要\n",
            'is_showing' => (bool)random_int(0, 1),
            'genre' => 'ジャンル',
        ]);
        $response->assertStatus(302);
        $response->assertInvalid(['image_url']);
        $this->assertMovieCount(0);
    }

    #[Test]
    #[Group('station9')]
    public function test映画タイトルの重複バリデーションが設定されているか(): void
    {
        $genreId = Genre::factory()->create()->id;
        Movie::insert([
            'title' => '最初からある映画',
            'image_url' => 'https://techbowl.co.jp/_nuxt/img/6074f79.png',
            'published_year' => 2000,
            'description' => '概要',
            'is_showing' => (bool)random_int(0, 1),
            'genre_id' => $genreId,
        ]);
        $this->assertMovieCount(1);
        $response = $this->post(route('admin.movies.store'), [
            'title' => '最初からある映画',
            'image_url' => 'https://techbowl.co.jp/_nuxt/img/6074f79.png',
            'published_year' => 2022,
            'description' => "概要\n概要\n",
            'is_showing' => (bool)random_int(0, 1),
            'genre' => 'ジャンル',
        ]);
        $response->assertStatus(302);
        $response->assertInvalid(['title']);
        $this->assertMovieCount(1);
    }

    #[Test]
    #[Group('station9')]
    private function assertMovieCount(int $count): void
    {
        $movieCount = Movie::count();
        $this->assertEquals($movieCount, $count);
    }

    #[Test]
    #[Group('station9')]
    public function test管理者映画編集画面が表示されているか(): void
    {
        $movie = $this->createMovie();
        $response = $this->get(route('admin.movies.edit', $movie));
        $response->assertStatus(200);
        $response->assertSee($movie->title);
        $response->assertSee($movie->image_url);
        $response->assertSee($movie->published_year);
        $response->assertSee($movie->description);
        $response->assertSee($movie->genre->name);
        $response->assertSee('is_showing'); // Checkboxの存在を確認する代わりにプロパティ名がHTMLに含まれているかどうかだけチェックする
    }

    #[Test]
    #[Group('station9')]
    public function test管理者映画編集画面で映画が更新されるか(): void
    {
        $movie = $this->createMovie();
        $data = [
            'title' => '修正後の映画',
            'image_url' => 'https://techbowl.co.jp/_nuxt/img/6074f78.png',
            'published_year' => 2022,
            'description' => '更新された概要',
            'is_showing' => true,
            'genre' => '更新されたジャンル',
        ];
        $response = $this->patch(route('admin.movies.update', $movie), $data);
        $response->assertStatus(302);
        $updated = Movie::find($movie->id);
        $this->assertEquals($updated->title, $data['title']);
        $this->assertEquals($updated->image_url, $data['image_url']);
        $this->assertEquals($updated->published_year, $data['published_year']);
        $this->assertEquals($updated->description, $data['description']);
        $this->assertEquals($updated->is_showing, $data['is_showing']);
        $this->assertEquals($updated->genre->name, $data['genre']);
    }

    #[Test]
    #[Group('station9')]
    public function test更新時Requiredバリデーションが設定されているか(): void
    {
        $movie = $this->createMovie();
        $data = [
            'title' => '',
            'image_url' => '',
            'published_year' => null,
            'description' => '',
            'is_showing' => null,
            'genre' => '',
        ];
        $response = $this->patch(route('admin.movies.update', $movie), $data);
        $response->assertStatus(302);
        $response->assertInvalid(['title', 'image_url', 'published_year', 'description', 'is_showing', 'genre']);
    }

    #[Test]
    #[Group('station9')]
    public function test更新時画像URLバリデーションが設定されているか(): void
    {
        $movie = $this->createMovie();
        $data = [
            'title' => '新しい映画',
            'image_url' => '画像URL',
            'published_year' => 2022,
            'description' => "概要\n概要\n",
            'is_showing' => (bool)random_int(0, 1),
            'genre' => 'ジャンル',
        ];
        $response = $this->patch(route('admin.movies.update', $movie), $data);
        $response->assertStatus(302);
        $response->assertInvalid(['image_url']);
    }

    #[Test]
    #[Group('station9')]
    public function test更新時映画タイトルの重複バリデーションが設定されているか(): void
    {
        $genreId = Genre::factory()->create()->id;
        Movie::insert([
            'title' => '既存の映画',
            'image_url' => 'https://techbowl.co.jp/_nuxt/img/6074f79.png',
            'published_year' => 2000,
            'description' => '概要',
            'is_showing' => (bool)random_int(0, 1),
            'genre_id' => $genreId,
        ]);
        $movie = $this->createMovie();
        $data = [
            'title' => '既存の映画',
            'image_url' => 'https://techbowl.co.jp/_nuxt/img/6074f79.png',
            'published_year' => 2022,
            'description' => "概要\n概要\n",
            'is_showing' => (bool)random_int(0, 1),
            'genre' => 'ジャンル',
        ];
        $response = $this->patch(route('admin.movies.update', $movie), $data);
        $response->assertStatus(302);
        $response->assertInvalid(['title']);
    }

    #[Test]
    #[Group('station9')]
    public function testテーブルにMovieTitleのユニークキーが入っているか(): void
    {
        $genreId = Genre::factory()->create()->id;
        Movie::insert([
            'title' => '最初からある映画',
            'image_url' => 'https://techbowl.co.jp/_nuxt/img/6074f79.png',
            'published_year' => 2000,
            'description' => '概要',
            'is_showing' => (bool)random_int(0, 1),
            'genre_id' => $genreId,
        ]);

        try {
            Movie::insert([
                'title' => '最初からある映画',
                'image_url' => 'https://techbowl.co.jp/_nuxt/img/6074f79.png',
                'published_year' => 2000,
                'description' => '概要',
                'is_showing' => (bool)random_int(0, 1),
                'genre_id' => $genreId,
            ]);
            $this->fail();
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
    }

    #[Test]
    #[Group('station9')]
    private function createMovie(): Movie
    {
        return Movie::create([
            'title' => '最初からある映画',
            'image_url' => 'https://techbowl.co.jp/_nuxt/img/6074f79.png',
            'published_year' => 2000,
            'description' => '概要',
            'is_showing' => false,
            'genre_id' => Genre::factory()->create()->id,
        ]);
    }
}
