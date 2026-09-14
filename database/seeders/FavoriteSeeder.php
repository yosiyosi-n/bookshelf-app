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

        $users = User::all()->keyBy('email');
        $books = Book::all()->keyBy('isbn');

        if ($users->isEmpty() || $books->isEmpty()) {
            return;
        }

        $fixedFavorites = [

            'yamada@example.com' => ['9784101010014', '9784101010021', '9784863940246'],

            'suzuki@example.com' => ['9784873115658', '9784048930598'],

            'tanaka@example.com' => ['9784422100524', '9784309226712', '9784822289607'],

            'sato@example.com' => ['9784101010021', '9784163902302', '9784478025819'],

            'takahashi@example.com' => ['9784422100524', '9784822251468']
        ];

        foreach ($fixedFavorites as $email => $isbns) {
            $user = $users->get($email);

            if ($user) {
                $genreIds = [];
                foreach ($isbns as $isbn) {
                    $book = $books->get($isbn);
                    if ($book) {
                        $genreIds[] = $book->id;
                    }
                }

                $user->favoriteBooks()->sync($genreIds);
            }
        }
    }
}
