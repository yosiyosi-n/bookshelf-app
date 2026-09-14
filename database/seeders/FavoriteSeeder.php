<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $books = Book::all();

        if ($users->isEmpty() || $books->isEmpty()) {
            return;
        }

        foreach ($users as $user) {
            $favoriteCount = rand(3, 5);

            $randomBookIds = $books->random($favoriteCount)->pluck('id')->toArray();

            $user->favoriteBooks()->syncWithoutDetaching($randomBookIds);
        }
    }
}
