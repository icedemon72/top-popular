<?php

namespace App\Http\Utils;

use Illuminate\Support\Facades\Auth;

class Utils
{
	public static function GetLikes(mixed $posts)
	{
		if (Auth::check()) {
			foreach ($posts as $post) {
				if(!$post->deleted) {
					foreach ($post->likes as $like) {
						if ($like->user_id == Auth::user()->id) {
							$post['likeType'] = $like->type;
							break;
						}
					}
				}
			} 
		}

		unset($posts['likes']);
		return $posts;
	}
}