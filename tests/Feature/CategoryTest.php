<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Tests\TestCase;

class CategoryTest extends TestCase
{
	/**
	 * @var \Illuminate\Contracts\Auth\Authenticatable
	 */
	private static ?User $user = null;

	/**
	 * @var \Illuminate\Contracts\Auth\Authenticatable
	 */
	private static ?User $admin = null;
	
	public function setUp(): void
	{
		parent::setUp();

		if (is_null(self::$user))
		{
			self::$user = User::factory()->create();

			self::$admin = User::factory()->create([
				'is_admin' => 1
			]);
		}
	}

    public function testCategoryListCanBeRendered(): void
    {
		$this->actingAs(self::$user);
        $response = $this->get('/categories');
        $response->assertOk();
    }

	public function testCreateCategoryFormCanBeRendered(): void
	{
		$this->actingAs(self::$admin);
        $response = $this->get('/categories/create');
        $response->assertOk();
	}

	public function testAdminCanCreateCategory(): void
	{
		$this->actingAs(self::$admin);
		$response = $this->post('/categories', ['name' => 'Test category']);
		$response->assertRedirect('/categories');
	}

	public function testUserCannotCreateCategory(): void
	{
		$this->actingAs(self::$user);
		$response = $this->post('/categories', ['name' => 'Test category 2']);
		$response->assertForbidden();
	}

	public function testEditCategoryFormCanBeRendered(): void
	{
		$this->actingAs(self::$admin);
		$category = Category::factory()->create();
        $response = $this->get('/categories/' . $category->id . '/edit');
        $response->assertOk();
	}

	public function testAdminCanEditCategory(): void
	{
		$this->actingAs(self::$admin);
		$category = Category::factory()->create();
		$response = $this->patch('/categories/' . $category->id, ['name' => 'Test category 2']);
		$response->assertRedirect('/categories');
	}

	public function testUserCannotEditCategory(): void
	{
		$this->actingAs(self::$user);
		$category = Category::factory()->create();
		$response = $this->patch('/categories/' . $category->id, ['name' => 'Test category 2']);
		$response->assertForbidden();
	}

	public function testAdminCanDeleteCategory(): void
	{
		$this->actingAs(self::$admin);
		$category = Category::factory()->create();
		$response = $this->delete('/categories/' . $category->id);
		$response->assertRedirect('/categories');
	}

	public function testUserCannotDeleteCategory(): void
	{
		$this->actingAs(self::$user);
		$category = Category::factory()->create();
		$response = $this->delete('/categories/' . $category->id);
		$response->assertForbidden();
	}
}