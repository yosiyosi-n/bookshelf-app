<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        if(!$user) {
            return;
        }

        $fixedBooks = [
            [
                'title' => '吾輩は猫である',
                'author' => '夏目漱石',
                'isbn' => '9784101010014',
                'published_date' => '1905-01-01',
                'genre' => '小説',
                'description' => '夏目漱石の処女小説。ユーモアと風刺に満ちた不朽の名作。',
            ],
            [
                'title' => '人を動かす',
                'author' => 'D・カーネギー',
                'isbn' => '9784422100524',
                'published_date' => '1936-10-01',
                'genre' => 'ビジネス, 自己啓発',
                'description' => '',
            ],
            [
                'title' => 'リーダブルコード',
                'author' => 'Dustin Boswell',
                'isbn' => '9784873115658',
                'published_date' => '2012-06-23',
                'genre' => '技術書',
                'description' => '',
            ],
            [
                'title' => '7つの習慣',
                'author' => 'スティーブン・R・コヴィー',
                'isbn' => '9784863940246',
                'published_date' => '2013-08-30',
                'genre' => 'ビジネス, 自己啓発',
                'description' => '',
            ],
            [
                'title' => '坊っちゃん',
                'author' => '夏目漱石',
                'isbn' => '9784101010021',
                'published_date' => '1906-04-01',
                'genre' => '小説',
                'description' => '',
            ],
            [
                'title' => 'サピエンス全史',
                'author' => 'ユヴァル・ノア・ハラリ',
                'isbn' => '9784309226712',
                'published_date' => '2016-09-08',
                'genre' => '歴史, 科学',
                'description' => '',
            ],
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'isbn' => '9784048930598',
                'published_date' => '2017-12-18',
                'genre' => '技術書',
                'description' => '',
            ],
            [
                'title' => '嫌われる勇気',
                'author' => '岸見一郎・古賀史健',
                'isbn' => '9784478025819',
                'published_date' => '2013-12-13',
                'genre' => '自己啓発',
                'description' => '',
            ],
            [
                'title' => '火花',
                'author' => '又吉直樹',
                'isbn' => '9784163902302',
                'published_date' => '2015-03-11',
                'genre' => '小説',
                'description' => '',
            ],
            [
                'title' => 'FACTFULNESS',
                'author' => 'ハンス・ロスリング',
                'isbn' => '9784822289607',
                'published_date' => '2019-01-11',
                'genre' => 'ビジネス, 科学',
                'description' => '',
            ],
            [
                'title' => 'コンテナ物語',
                'author' => 'マルク・レビンソン',
                'isbn' => '9784822251468',
                'published_date' => '2007-01-18',
                'genre' => 'ビジネス, 歴史',
                'description' => '',
            ],
        ];

        foreach ($fixedBooks as $index => $bookDate) {
            $number = $index + 1;

            $book = Book::firstOrCreate(
                ['isbn' => $bookDate['isbn']],
                [
                    'user_id' => $user->id,
                    'title' => $bookDate['title'],
                    'author' => $bookDate['author'],
                    'published_date' => $bookDate['published_date'],
                    'description' => $bookDate['description'],
                    'image_url' => "https://placehold.co/200x300/e2e8f0/475569?text={$number}",
                ]
            );

            $genreNames = array_map('trim', explode(',', $bookDate['genre']));

            $genreIds = Genre::whereIn('name',$genreNames)->pluck('id')->toArray();

            if (!empty($genreIds)) {
                $book->genres()->sync($genreIds);
            }
        }
    }
}
