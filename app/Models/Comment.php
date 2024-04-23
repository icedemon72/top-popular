<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent');
    }


    protected $fillable = [
        'body',
        'post_id',
        'user_id',
        'parent',
    ];

    protected $hidden = [
        'deleted'
    ];
}
