<?php

namespace App\Models;

use App\Observers\LikeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[ObservedBy([LikeObserver::class])]
class Like extends Model
{
    use HasFactory;

    public function likeable(): MorphTo
    {
        return $this->morphTo();
    }

    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'type'
    ];
}

