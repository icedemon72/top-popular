<?php

namespace App\Http\Filters;

use Carbon\Carbon;

class PostFilter extends Filter
{
	protected array $filterable = [
		'search',
		'archived',
		'poster',
		'sort',
		'time',
		'category'
	];

	protected array $sortable = [
		'title',
		'popular',
		'date',
		'category',
		'poster',
		'id',
		'comments'
	];

	public function search($value = null): void
	{
		if ($value) {
			$this->builder
				->where('title', 'like', "%{$value}%")
				->orWhere('body', 'like', "%{$value}%");
		}
	}

	public function archived($value = null): void
	{
		if ($value) {
			$this->builder->where('archived', '=', $value);
		}
	}

	public function poster($value = null): void
	{
		if($value) {
			$this->builder->where('user_id', '=', $value);
		}
	}

	public function category($value = null): void 
	{
		if($value) {
			if(is_array($value)) {
				$this->builder->whereIn('category_id', $value);
			} else {
				$this->builder->where('category_id', '=', $value);
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

	public function sort($value): void 
	{
		if($value) {
			if (str_contains($value, '_')) {
				$exploded = explode("_", $value);
				$sort = $exploded[0];
				$order = $exploded[1];
				
				if(in_array($sort, $this->sortable) && in_array($order, ['asc', 'desc'])) {
					if($sort == 'date') {
						$this->builder->orderBy('created_at', $order);
					} else if($sort == 'comments') {
						$this->builder->orderBy('comments_count', $order);
					} else if($sort == 'category') {
						$this->builder->join('categories', 'categories.id', '=', 'posts.category_id')->orderBy('categories.name', $order);
					} else if($sort == 'poster') {
						$this->builder->join('users', 'users.id', '=', 'posts.user_id')->orderBy('users.username', $order);
					} else  {
						$this->builder->orderBy($sort, $order);
					}
				}
			} 
			else if($value == 'popular') {
				$this->builder->withCount('comments')->orderBy('comments_count');
			}
			else if($value == 'top') {
				$this->builder->withCount('likes')->orderBy('likes_count', 'desc');
			}
		}
	}
}
