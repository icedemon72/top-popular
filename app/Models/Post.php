<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    use HasFactory;
    use Sortable;
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



    // TODO: add likes, comments etc.

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'category_id',
        'archived',
        'created_at',
        'updated_at'
    ];

    protected $filterFields = [
        'tags',
        'poster',
        'title',
        'body',
        'created_at'
      ];
          
      protected $sortFields = [
        'title',
        'created_at',
        'poster',
        'category',
        'comment'
      ];

    // protected $hidden = [
       
    // ];

}
