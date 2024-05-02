<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

// use Illuminate\Database\Eloquent\Builder;
// use App\Filter\PostFilter;

class Post extends Model
{
    use HasFactory;
    use Filterable;

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function poster(): BelongsTo 
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function comments(): HasMany 
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    // public function scopeFilter(Builder $builder, mixed $request): Builder
    // {
    //     return (new PostFilter($request))->filter($builder);
    // }



    // TODO: add likes, comments etc.

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'category_id',
        'archived',
        'created_at',
        'updated_at',
        'likeCount',
        'dislikeCount'
    ];         
    //   protected $sortFields = [
    //     'title',
    //     'created_at',
    //     'poster',
    //     'category',
    //     'comment'
    //   ];

    // protected $hidden = [
       
    // ];

}
