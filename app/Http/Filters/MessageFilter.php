<?php

namespace App\Http\Filters;

use Carbon\Carbon;

class MessageFilter extends Filter
{
	protected array $filterable = [
		'search',
		'status',
		'time',
		'category'
	];

	// protected array $sortable = [
	// 	'id',
	// 	'name',
	// 	'username',
	// 	'email',
	// ];

	public function search($value = null): void 
	{
		if($value) {
			$this->builder->where('title', 'like', "%{$value}%")
				->orWhere('body', 'like', "%{$value}%")
				->orWhere('category', 'like', "{$value}%")
				->orWhere('status', 'like', "{$value}%");
		}
	}

	public function status($value = null): void 
	{
		if($value) {
			if(is_array($value)) {
				$index = in_array('na', $value);
				$this->builder->whereIn('status', $value)->when($index, function ($query) {
					return $query->orWhereNull('status');
				});
			} else {
				$this->builder->where('status', '=', $value);
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
