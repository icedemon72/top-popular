<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Comment extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->BelongsTo(Post::class);
    }

    public function parent(): BelongsTo
    {
        return $this->BelongsTo(Comment::class);
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
