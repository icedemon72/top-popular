<?php

namespace App\Http\Utils;

use Illuminate\Support\Facades\Auth;

function getRandomColor(): string
{
		$letters = '0123456789ABCDEF';
		$color = '#';
		for ($i = 0; $i < 6; $i++) {
				$color .= $letters[rand(0, 15)];
		}
		return $color;
}

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

	/** 
	* Returns icehouse-ventures/laravel-chartjs chart object with $days days (suitable for days... duuuuh)
	* @param mixed $data Data to be shown on the chart
	* @param int $days How many X-axis nodes (days) are there
	* @param string $type Type of returning chart: bar, line, polarArea etc. See chartjs.org for more
	* @param string $name Chart name
	*/
	public static function GetChart(
		mixed $data, int $days, string $type, string $name, 
		string $label = 'date', string $value = 'data', 
		string $background = 'rgb(59, 130, 246, 0.31)', string $border = 'rgba(59, 130, 246, 0.7)'
	): mixed
	{
		$dates = array();

		if($type == 'pie' || $type == 'doughnut') {
			foreach($data as $pie) {
				$dates[$pie->category->name] = $pie->data;
				$background = array();
				$border = '#000000';
				for ( $i = 0; $i < 6; $i++ ) {
					array_push($background, getRandomColor());
				}
			}
		}
		else {
			for ($i = 0 ; $i <= $days; $i++) {
				$date = now()->subDays($days)->copy()->addDays($i)->format('Y-m-d');
				$dates[$date] = 0;
			}

			foreach($data as $node) {
				$dates[$node[$label]] = $node[$value];
			}
		}

		$chart = app()
			->chartjs
			->name(substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRTUVWXYZ'),0,5))
			->type($type)
			->labels(array_keys($dates))
			->datasets([
				[
					"label" => $name,
					"borderColor" => $border,
					"backgroundColor" => $background,
					"data" => array_values($dates),
					'hoverOffset' => 4
				]
			])
			->options([
				'plugins' => [
					'colors' => [
						'forceOverride' => true
					]
				]
			]);

		return $chart;

	}

}