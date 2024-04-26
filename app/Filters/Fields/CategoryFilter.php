<?php 

namespace App\Filters\Fields;

class CategoryFilter
{
	function __invoke($query, $categories)
	{
		return $query->whereIn('category_id', $categories);
	}
}