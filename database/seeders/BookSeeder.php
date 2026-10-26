<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        if (! $user) {
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
                'description' => '時代を超越する不滅のビジネスバイブル。他人の立場に立ち、自尊心を傷つけずに人を動かすための具体的な行動指針。',
            ],
            [
                'title' => 'リーダブルコード',
                'author' => 'Dustin Boswell',
                'isbn' => '9784873115658',
                'published_date' => '2012-06-23',
                'genre' => '技術書',
                'description' => '「コードは理解しやすくなければならない」という大原則のもと、名前の付け方、コメントの書き方、制御フローの簡潔化など、美しい設計を解説した名著。',
            ],
            [
                'title' => '7つの習慣',
                'author' => 'スティーブン・R・コヴィー',
                'isbn' => '9784863940246',
                'published_date' => '2013-08-30',
                'genre' => 'ビジネス, 自己啓発',
                'description' => '人生を長期的な成功と真の幸福に導くための普遍的な原則。個人の自立から社会的な成功、そして自己刷新に至るステップを体系的に説き明かす。',
            ],
            [
                'title' => '坊っちゃん',
                'author' => '夏目漱石',
                'isbn' => '9784101010021',
                'published_date' => '1906-04-01',
                'genre' => '小説',
                'description' => '夏目漱石の代表作の一つ。正義感が強く無鉄砲な青年「坊っちゃん」が、四国の旧制中学校に数学教師として赴任し、周囲の理不尽な大人たちに立ち向かう。',
            ],
            [
                'title' => 'サピエンス全史',
                'author' => 'ユヴァル・ノア・ハラリ',
                'isbn' => '9784309226712',
                'published_date' => '2016-09-08',
                'genre' => '歴史, 科学',
                'description' => '虚弱なホモ・サピエンスが、なぜ地球の支配者になれたのか。「認知革命」「農業革命」「科学革命」という3つの革命を軸に、人類の歴史を解き明かす。',
            ],
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'isbn' => '9784048930598',
                'published_date' => '2017-12-18',
                'genre' => '技術書',
                'description' => 'プロフェッショナルな職人として、保守性が高く洗練されたコードを書くための実践書。リファクタリングの手法やコードの不吉な臭いを見分ける知恵を凝縮。',
            ],
            [
                'title' => '嫌われる勇気',
                'author' => '岸見一郎・古賀史健',
                'isbn' => '9784478025819',
                'published_date' => '2013-12-13',
                'genre' => '自己啓発',
                'description' => 'アルフレッド・アドラーの心理学を、哲学者と青年の対話形式で説き明かす一冊。「人間の悩みはすべて対話関係の悩みである」とし、今を生きる勇気を与える。',
            ],
            [
                'title' => '火花',
                'author' => '又吉直樹',
                'isbn' => '9784163902302',
                'published_date' => '2015-03-11',
                'genre' => '小説',
                'description' => 'お笑い芸人である又吉直樹による芥川賞受賞作。売れない若手芸人の徳永と、天才肌の先輩芸人・神谷の純粋な葛藤と奇妙な師弟関係を描いた青春物語。',
            ],
            [
                'title' => 'FACTFULNESS',
                'author' => 'ハンス・ロスリング',
                'isbn' => '9784822289607',
                'published_date' => '2019-01-11',
                'genre' => 'ビジネス, 科学',
                'description' => 'データや客観的な事実に基づき、世界を正しく見るための教科書。私たちが陥りがちな10の思い込みを暴き、世界が少しずつ良くなっている現実を証明する。',
            ],
            [
                'title' => 'コンテナ物語',
                'author' => 'マルク・レビンソン',
                'isbn' => '9784822251468',
                'published_date' => '2007-01-18',
                'genre' => 'ビジネス, 歴史',
                'description' => 'ただの「鉄の箱」であるコンテナの普及が、世界の物流コストを激変させ、グローバル経済を誕生させたダイナミックな歴史を緻密に追った経済ノンフィクション。',
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

            $genreIds = Genre::whereIn('name', $genreNames)->pluck('id')->toArray();

            if (! empty($genreIds)) {
                $book->genres()->sync($genreIds);
            }
        }
    }
}
