<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function poster(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }


    // TODO: add likes, comments etc.

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'category_id'
    ];

    protected $hidden = [
        'archived'
    ];

}
