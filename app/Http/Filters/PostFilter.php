<?php

namespace App\Http\Filters;

class PostFilter extends Filter
{
	protected array $filterable = [
		'search',
		'archived',
		'poster'
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
}
