<?php

namespace App\Http\Filters;

use Carbon\Carbon;

class CommentFilter extends Filter
{
	protected array $filterable = [
		'time',
		'sort'
	];

	protected array $sortable = [

	];

	public function sort($value = null): void 
	{	
		if($value) {
			if (str_contains($value, '_')) {
				$exploded = explode("_", $value);
				$sort = $exploded[0];
				$order = $exploded[1];
				
				if(in_array($sort, $this->sortable) && in_array($order, ['asc', 'desc'])) {
					if($value == 'popular') {
						$this->builder->withCount('replies')->orderBy('replies_count');
					}
					else if($value == 'top') {
						$this->builder->withCount('likes')->orderBy('likes_count', 'desc');
					}
				}
			} 
		}
	}

	public function time($value = null): void
	{
		if($value) {
			if ($value == 'today') {
				$this->builder->whereDate('created_at', Carbon::today());
			} else if ($value == 'week') {
				$this->builder->where('created_at', '>', Carbon::now()->subDays(7)->endOfDay());
			} else if ($value == 'month') {
				$this->builder->where('created_at', '>', Carbon::now()->subDays(30)->endOfDay());
			} else if ($value == 'year') {
				$this->builder->where('created_at', '>', Carbon::now()->subDays(365)->endOfDay());
			}
		}
	}
}
