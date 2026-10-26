<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
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

        $fixedReviews = [
            ['isbn' => '9784101010014', 'email' => 'yamada@example.com', 'rating' => 4, 'comment' => '猫の視点から描かれる人間模様がユーモラスで、今読んでも新鮮な気づきがあります。'],
            ['isbn' => '9784101010014', 'email' => 'suzuki@example.com', 'rating' => 5, 'comment' => '漱石の言葉選びのセンスが素晴らしく、日本の文学の奥深さを実感できる一冊。'],

            ['isbn' => '9784422100524', 'email' => 'sato@example.com', 'rating' => 5, 'comment' => '人間関係に悩んだときは必ず読み返しています。すべてのビジネスパーソンにおすすめ。'],
            ['isbn' => '9784422100524', 'email' => 'takahashi@example.com', 'rating' => 4, 'comment' => '相手の立場に立つことの大切さを学びました。実践するのは難しいですが、意識が変わります。'],
            ['isbn' => '9784422100524', 'email' => 'yamada@example.com', 'rating' => 4, 'comment' => '古典的な名著ですが、現代のコミュニケーションにも完全に通用する普遍的な内容です。'],

            ['isbn' => '9784873115658', 'email' => 'suzuki@example.com', 'rating' => 5, 'comment' => 'チーム開発をする上でのバイブル。読みやすいコードを書く具体的なテクニックが満載です。'],
            ['isbn' => '9784873115658', 'email' => 'tanaka@example.com', 'rating' => 5, 'comment' => '新人の頃に出会いたかった本。命名規則の重要性など、すぐに業務に活かせる内容ばかりです。'],
            ['isbn' => '9784873115658', 'email' => 'sato@example.com', 'rating' => 4, 'comment' => '解説がシンプルで分かりやすい。プログラミングの質がワンランク上がった気がします。'],

            ['isbn' => '9784863940246', 'email' => 'takahashi@example.com', 'rating' => 4, 'comment' => '人生の基礎となるマインドセットを体系的に学べます。ボリュームがありますが読む価値あり。'],
            ['isbn' => '9784863940246', 'email' => 'yamada@example.com', 'rating' => 5, 'comment' => '単なる成功法則ではなく、人間としての生き方や人格を磨くための素晴らしい本。'],
            ['isbn' => '9784863940246', 'email' => 'suzuki@example.com', 'rating' => 3, 'comment' => '内容は非常に素晴らしいですが、実践して習慣化するまでにはかなりの根気が必要です。'],

            ['isbn' => '9784101010021', 'email' => 'tanaka@example.com', 'rating' => 4, 'comment' => '江戸っ子気質で一本気な坊っちゃんのキャラクターが魅力的で、一気に読めました。'],
            ['isbn' => '9784101010021', 'email' => 'sato@example.com', 'rating' => 3, 'comment' => 'テンポが良くて面白いですが、結末が少しあっけない印象を受けました。'],
            ['isbn' => '9784101010021', 'email' => 'takahashi@example.com', 'rating' => 4, 'comment' => '理不尽な社会に立ち向かう姿が痛快。夏目漱石の作品の中でも特に親しみやすい。'],
            ['isbn' => '9784101010021', 'email' => 'sato@example.com', 'rating' => 5, 'comment' => '登場人物たちのあだ名やキャラクターが立っていて、何度読み返しても飽きない魅力があります。'],

            ['isbn' => '9784309226712', 'email' => 'yamada@example.com', 'rating' => 5, 'comment' => '人類の歴史を全く新しい視点から捉え直す名著。目から鱗が落ちるような衝撃の連続でした。'],
            ['isbn' => '9784309226712', 'email' => 'suzuki@example.com', 'rating' => 4, 'comment' => '「虚構」を信じる力が人類を発展させたという説が非常に興味深く、引き込まれました。'],
            ['isbn' => '9784309226712', 'email' => 'tanaka@example.com', 'rating' => 4, 'comment' => '歴史だけでなく哲学や科学の要素も詰まっていて、世界の捉え方がガラリと変わる本です。'],

            ['isbn' => '9784048930598', 'email' => 'sato@example.com', 'rating' => 5, 'comment' => 'リーダブルコードより一歩踏み込んだ、プロフェッショナルな設計思想が学べる良書です。'],
            ['isbn' => '9784048930598', 'email' => 'takahashi@example.com', 'rating' => 4, 'comment' => 'コードの「不吉な臭い」に気づくための知恵が詰まっています。リファクタリングの参考に。'],

            ['isbn' => '9784478025819', 'email' => 'yamada@example.com', 'rating' => 5, 'comment' => '対話形式なのでスラスラ読めました。他人の期待に応える必要はないという言葉に救われます。'],
            ['isbn' => '9784478025819', 'email' => 'suzuki@example.com', 'rating' => 4, 'comment' => '自分の課題と他者の課題を分離するという考え方は、人間関係のストレスを劇的に減らしてくれます。'],
            ['isbn' => '9784478025819', 'email' => 'tanaka@example.com', 'rating' => 5, 'comment' => '過去のトラウマに囚われず、これからの人生をどう生きるかは自分次第だと強く背中を押されました。'],

            ['isbn' => '9784163902302', 'email' => 'sato@example.com', 'rating' => 4, 'comment' => 'お笑いの世界のきらめきと過酷さがリアルに描かれており、切なくも美しい純文学でした。'],
            ['isbn' => '9784163902302', 'email' => 'takahashi@example.com', 'rating' => 3, 'comment' => '芸人さんならではの繊細な心理描写が見事。後半の展開は好みが分かれるかもしれません。'],
            ['isbn' => '9784163902302', 'email' => 'yamada@example.com', 'rating' => 4, 'comment' => '夢を追うことの尊さと難しさを考えさせられる作品。文章のリズムが心地よかったです。'],

            ['isbn' => '9784822289607', 'email' => 'suzuki@example.com', 'rating' => 5, 'comment' => 'ニュースを見て世界が悪くなっていると思っている人にこそ読んでほしい。データが示す事実は希望に満ちています。'],
            ['isbn' => '9784822289607', 'email' => 'tanaka@example.com', 'rating' => 5, 'comment' => '自分がどれほど思い込みで世界を見ていたかを痛感しました。バイアスをなくす訓練になります。'],
            ['isbn' => '9784822289607', 'email' => 'sato@example.com', 'rating' => 4, 'comment' => '世界の真の姿をフラットに捉えるための必須の教養。グラフや図解も分かりやすくて良かったです。'],

            ['isbn' => '9784822251468', 'email' => 'takahashi@example.com', 'rating' => 4, 'comment' => 'ただの箱が世界経済をどう変えたのか、映画のようなドラマがあり知的好奇心が刺激されました。'],
            ['isbn' => '9784822251468', 'email' => 'yamada@example.com', 'rating' => 5, 'comment' => '物流のイノベーションがもたらした影響の大きさを、緻密な取材に基づき描き切った傑作ノンフィクション。'],
            ['isbn' => '9784822251468', 'email' => 'suzuki@example.com', 'rating' => 4, 'comment' => '一見地味なテーマですが、標準化がいかに重要であるかをビジネスの視点から学べる深い内容です。'],
        ];

        foreach ($fixedReviews as $reviewData) {
            $book = $books->get($reviewData['isbn']);
            $user = $users->get($reviewData['email']);

            if ($book && $user) {
                Review::create([
                    'book_id' => $book->id,
                    'user_id' => $user->id,
                    'rating' => $reviewData['rating'],
                    'comment' => $reviewData['comment'],
                ]);
            }
        }
    }
}
