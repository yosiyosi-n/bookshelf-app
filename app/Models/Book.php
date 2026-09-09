<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'author',
        'isbn',
        'published_date',
        'image_url',
        'description',
    ];

    protected $casts = [
        'published_date' => 'date',
    ];

    /**
     * この本を登録したユーザー（1対多の「逆」）
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * この本が持っているジャンル（多対多）
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    /**
     * この本に対するレビュー一覧（1対多）
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * この本をお気に入り登録しているユーザー一覧（多対多）
     */
    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'book_user');
    }

}
