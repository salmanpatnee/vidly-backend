<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $movies = [
            [
                'title' => 'Terminator',
                'genre_id' => 1,
                'numberInStock' => 6,
                'dailyRentalRate' => 2.5,
                // 'publishDate' => "2018-01-03T19:04:28.809Z",
                'is_liked' => 1
            ],
            [
                'title' => 'Die Hard',
                'genre_id' => 3,
                'numberInStock' => 5,
                'dailyRentalRate' => 2.5,
                // 'publishDate' => "2018-01-03T19:04:28.809Z",
                'is_liked' => 0
            ],
        ];

        foreach ($movies as $movie) {
            Movie::create($movie);
        }
    }
}
