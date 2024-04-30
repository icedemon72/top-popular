<?php

namespace App\Observers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;

class LikeObserver
{
    /**
     * Handle the Like "created" event.
     */
    public function created(Like $like): void
    {
        $model = ($like->likeable_type === 'post') ? Post::where('id', $like->likeable_id) : Comment::where('id', $like->likeable_id);
        $instance = $model->get()->first();

        ($like->type == 'like') ? $instance->likeCount++ : $instance->dislikeCount++;
        $instance->timestamps = false;
        $instance->save();
    }

    /**
     * Handle the Like "updated" event.
     */
    public function updated(Like $like): void
    {
        $model = ($like->likeable_type === 'post') ? Post::where('id', $like->likeable_id) : Comment::where('id', $like->likeable_id);
        $instance = $model->get()->first();
        
        if($like->type === 'like') {
            $instance->likeCount++;
            $instance->dislikeCount--;
        } else {
            $instance->likeCount--;
            $instance->dislikeCount++;
        }

        $instance->timestamps = false;
        $instance->save();
    }

    /**
     * Handle the Like "deleted" event.
     */
    public function deleted(Like $like): void
    {
        $model = ($like->likeable_type === 'post') ? Post::where('id', $like->likeable_id) : Comment::where('id', $like->likeable_id);
        $instance = $model->get()->first();

        ($like->type == 'like') ? $instance->likeCount-- : $instance->dislikeCount--;

        $instance->timestamps = false;
        $instance->save();
    }

    /**
     * Handle the Like "restored" event.
     */
    public function restored(Like $like): void
    {
        //
    }

    /**
     * Handle the Like "force deleted" event.
     */
    public function forceDeleted(Like $like): void
    {
        //
    }
}
