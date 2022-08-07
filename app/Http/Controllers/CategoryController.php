<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $categories = Category::all();

		return view('categories.index', [
			'categories' => $categories
		]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        $this->authorize('create', Category::class);

		return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
	 * @param  \App\Services\CategoryService $categoryService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCategoryRequest $request, CategoryService $categoryService): RedirectResponse
    {
        $this->authorize('create', Category::class);
		$categoryService->createCategory($request->input('name'));

		return redirect()->route('categories.index')
			->with(['action' => 'category_created']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Category $category): View
    {
        $this->authorize('update', $category);

		return view('categories.edit', [
			'category' => $category
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCategoryRequest $request, Category $category, CategoryService $categoryService): RedirectResponse
    {
        $this->authorize('update', $category);

		$categoryService->updateCategory(
			$category->id,
			$request->input('name')
		);

		return redirect()->route('categories.index')
			->with(['action' => 'category_updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        $this->authorize('update', $category);
		$category->delete();

		return redirect()->route('categories.index')
			->with(['action' => 'category_deleted']);
    }
}
