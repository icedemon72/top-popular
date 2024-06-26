<?php

namespace App\Http\Filters;

class CategoryFilter extends Filter
{
	protected array $filterable = [
		'search',
		'sort'
	];

	protected array $sortable = [
		'name',
		'posts',
		'id'
	];

	public function search($value = null): void
	{
		if ($value) {
			$this->builder
				->where('name', 'like', "%{$value}%");
		}
	}

	public function sort($value = null): void 
	{	
		if($value) {
			if (str_contains($value, '_')) {
				$exploded = explode("_", $value);
				$sort = $exploded[0];
				$order = $exploded[1];
				
				if(in_array($sort, $this->sortable) && in_array($order, ['asc', 'desc'])) {
					 if($sort == 'posts') {
						$this->builder->orderBy('posts_count', $order);
					} else {
						$this->builder->orderBy($sort, $order);
					}
				}
			} 
		}
	}
}
