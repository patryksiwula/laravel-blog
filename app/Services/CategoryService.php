<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryService
{	
	/**
	 * Create a new category
	 *
	 * @param  string $name
	 * @return \App\Models\Category
	 */
	public function createCategory(string $name): Category
	{
		$category = Category::create([
			'name' => $name,
			'slug' => Str::slug($name)
		]);

		return $category;
	}
	
	/**
	 * Update the selected category
	 *
	 * @param  int $id
	 * @param  string $name
	 * @return \App\Models\Category
	 */
	public function updateCategory(int $id, string $name): Category
	{
		$category = Category::find($id);

		if ($category->name !== $name)
		{
			$category->name = $name;
			$category->slug = Str::slug($name);
			$category->save();
		}

		return $category;
	}
}