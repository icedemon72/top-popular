<?php

namespace App\Http\Filters;

class CategoryFilter extends Filter
{
	protected array $filterable = [
		'search'
	];

	public function search($value = null): void
	{
		if ($value) {
			$this->builder
				->where('name', 'like', "%{$value}%");
		}
	}
}
