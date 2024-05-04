<?php

namespace App\Http\Filters;

class UserFilter extends Filter
{
	protected array $filterable = [
		'search',
		'sort',
		'role'
	];

	protected array $sortable = [
		'id',
		'name',
		'username',
		'email',
		'role'
	];

	public function search($value = null): void
	{
		if ($value) {
			$this->builder
				->where('name', 'like', "%{$value}%")
				->orWhere('username', 'like', "%{$value}%")
				->orWhere('email', 'like', "{$value}%")
				->orWhere('role', '=', "{$value}");
		}
	}

	public function role($value = null): void 
	{
		if($value) {
			if(is_array($value)) {
				$this->builder->whereIn('role', $value);
			} else {
				$this->builder->where('role', '=', $value);
			}
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
					$this->builder->orderBy($sort, $order);
				}
			} 
		}
	}

}