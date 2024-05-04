<?php

namespace App\Http\Filters;

class TagFilter extends Filter
{
	protected array $filterable = [
		'search',
		'sort'
	];

	protected array $sortable = [
		'name',
		'category',
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
					 if($sort == 'category') {
						// $this->builder->join('categories', 'categories.id', '=', 'tags.categories_id')->orderBy('posts_count', $order);
						// implement this later...
					} else {
						$this->builder->orderBy($sort, $order);
					}
				}
			} 
		}
	}

}