<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    use Filterable;
    use Sortable;

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    protected $fillable = [
        'name',
        'icon'
    ];
}
