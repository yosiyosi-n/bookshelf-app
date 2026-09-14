<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $reviews = Review::all();

        if ($users->isEmpty() || $reviews->isEmpty()) {
            return;
        }

        foreach ($reviews as $review) {
            $potentialLikers = $users->where('id','!=',$review->user_id);

            if ($potentialLikers->isNotEmpty()) {
                $likeCount = rand(0,min(3,$potentialLikers->count()));

                if ($likeCount > 0) {
                    $likerIds = $potentialLikers->random($likeCount)->pluck('id')->toArray();

                    $review->likedByUsers()->syncWithoutDetaching($likerIds);
                }
            }
        }
    }
}
