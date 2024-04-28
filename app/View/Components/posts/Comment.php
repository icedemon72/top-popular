<?php

namespace App\View\Components\posts;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Comment extends Component
{
    // public mixed $createdAt;
    // public mixed $timeAgo;
    public mixed $op;
    public mixed $comment;
    public mixed $archived;

    
    /**
     * Create a new component instance.
     */
    public function __construct($comment, $op, $archived)
    {
        // $this->createdAt = $createdAt;
        $this->op = $op;
        $this->comment = $comment;
        $this->archived = $archived;
        // $this->$timeAgo = Carbon::parse($comment->created_at)->diffForHumans();
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $timeAgo = Carbon::parse($this->comment->created_at)->diffForHumans();
        $edited = $this->comment->created_at != $this->comment->updated_at;
        return view('components.posts.comment', compact('timeAgo', 'edited'));
    }
}
