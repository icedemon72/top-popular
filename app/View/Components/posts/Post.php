<?php

namespace App\View\Components\posts;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Post extends Component
{
    /**
     * Create a new component instance.
     */
    public mixed $post;
    public bool $profile;
    public function __construct($post, $profile = false)
    {
        $this->post = $post;
        $this->profile = $profile;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $timeAgo = Carbon::parse($this->post->created_at)->diffForHumans();
        $edited = $this->post->created_at != $this->post->updated_at;
        return view('components.posts.post', compact('timeAgo', 'edited'));
    }
}
