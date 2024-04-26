<?php 

namespace App\Filters;
use App\Filters\Fields\CategoryFilter;

class PostFilters {
	/*
	* Filter array with "to-apply" filter classes
	*/
	protected $filters = [
		'category' => CategoryFilter::class,
	];

	public function apply($query) {
		foreach ($this->receivedFilters() as $name => $value) {
			$filterInstance = new $this->filters[$name];
			$query = $filterInstance($query, $value);
		}
		return $query;
	}

	public function receivedFilters()
	{
		return request()->only(array_keys($this->filters));
	}
}