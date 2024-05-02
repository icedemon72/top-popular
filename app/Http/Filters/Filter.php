<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class Filter
{

	protected Builder $builder;

	protected array $filterable = [];

	public function __construct(protected Request $request)
	{
	}

	/**
	 * Apply the filters on the builder.
	 *
	 * @param Builder $builder
	 *
	 * @return Builder
	 */
	public function apply(Builder $builder): Builder
	{
		$this->builder = $builder;

		foreach ($this->getFilters() as $filter => $value) {
			if (method_exists($this, $filter)) {
				call_user_func_array([$this, $filter], [$value]);
			}
		}

		return $this->builder;
	}

	/**
	 * Get the list of filters and their values from the request.
	 *
	 * @return array
	 */
	protected function getFilters(): array
	{
		return array_filter($this->request->only($this->filterable));
	}
}
