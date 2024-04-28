<?php

namespace App\Http\Utils;

use Illuminate\Support\Facades\Auth;

class Utils
{
	public static function GetLikes(mixed $posts)
	{
		// This will make this code uglier, but will improve performance for
		// not logged in users (no need to check if they liked the post...)
		if (Auth::check()) {
			foreach ($posts as $post) {
				$count = (object) [
					'likes' => 0,
					'dislikes' => 0
				];

				foreach ($post->likes as $like) {
					($like->type == 'like')
						? $count->likes++
						: $count->dislikes++;

					if ($like->user_id == Auth::user()->id) {
						$post['likeType'] = $like->type;
					}
				}

				$post['count'] = $count;
				unset($post['likes']);
			}
		} else {
			foreach ($posts as $post) {
				$count = (object) [
					'likes' => 0,
					'dislikes' => 0
				];

				foreach ($post->likes as $like) {
					($like->type == 'like')
						? $count->likes++
						: $count->dislikes++;
				}

				$post['count'] = $count;
				unset($post['likes']);
			}
		}

		return $posts;
	}
}
