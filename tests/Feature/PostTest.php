<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostTest extends TestCase
{
	/**
	 * @var \Illuminate\Contracts\Auth\Authenticatable
	 */
	protected static ?User $user1 = null;

	/**
	 * @var \Illuminate\Contracts\Auth\Authenticatable
	 */
	protected static ?User $user2 = null;

	/**
	 * @var \Illuminate\Contracts\Auth\Authenticatable
	 */
	protected static ?User $admin = null;

	protected static ?Category $category = null;

	public function setUp(): void
	{
		parent::setUp();

		if (is_null(self::$user1))
		{
			self::$user1 = User::factory()->create();
			self::$user2 = User::factory()->create();

			self::$admin = User::factory()->create([
				'is_admin' => 1
			]);

			self::$category = Category::factory()->create();
		}
	}

    public function testPostsCanBeRendered()
    {
        $response = $this->get('/posts');
        $response->assertOk();
    }

	public function testSinglePostCanBeRendered(): void
	{
		$post = Post::factory()->create([
			'category_id' => self::$category->id
		]);

		$response = $this->get('/posts/' . $post->slug);
		$response->assertOk();
	}

	public function testCreatePostFormCanBeRendered(): void
	{
		$this->actingAs(self::$user1);
		$response = $this->get('/posts/create');
		$response->assertOk();
	}

	public function testUserCanCreatePost(): void
	{
		$this->actingAs(self::$user1);

		Storage::fake('test_uploads');
		$file = UploadedFile::fake()->image('post_image.jpg');

		$request = $this->post('/posts', [
			'post_title' => 'Test post1',
			'post_content' => 'Test post content',
			'post_image' => $file,
			'post_category' => 1
		]);

		$request->assertRedirect('/posts/test-post1');
	}

	public function testUserCanDisplayTheEditFormOfHisPost(): void
	{
		$this->actingAs(self::$user1);

		$post = Post::factory()->create([
			'user_id' => self::$user1->id,
			'category_id' => self::$category->id
		]);

		$response = $this->get('/posts/' . $post->slug . '/edit');
		$response->assertOk();
	}

	public function testUserCannotDisplayTheEditFormOfOtherUsersPost(): void
	{
		$this->actingAs(self::$user1);

		$post = Post::factory()->create([
			'user_id' => self::$user2->id,
			'category_id' => self::$category->id
		]);

		$response = $this->get('/posts/' . $post->slug . '/edit');
		$response->assertForbidden();
	}

	public function testUserCanEditHisPost(): void
	{
		$this->actingAs(self::$user1);

		$post = Post::factory()->create([
			'user_id' => self::$user1->id,
			'category_id' => self::$category->id
		]);

		$response = $this->patch('/posts/' . $post->slug, [
			'post_title' => 'Test title1',
			'post_content' => 'Test content',
			'post_image' => null,
			'post_category' => 1
		]);
		
		$response->assertRedirect('/posts/test-title1');
	}

	public function testUserCannotEditOtherUsersPost(): void
	{
		$this->actingAs(self::$user1);

		$post = Post::factory()->create([
			'user_id' => self::$user2->id,
			'category_id' => self::$category->id
		]);

		$response = $this->patch('/posts/' . $post->slug, [
			'post_title' => 'Test title2',
			'post_content' => 'Test content',
			'post_image' => null,
			'post_category' => 1
		]);
		$response->assertForbidden();
	}

	public function testAdminCanEditOtherUsersPost(): void
	{
		$this->actingAs(self::$admin);

		$post = Post::factory()->create([
			'user_id' => self::$user1->id,
			'category_id' => self::$category->id
		]);

		$response = $this->patch('/posts/' . $post->slug, [
			'post_title' => 'Test title3',
			'post_content' => 'Test content',
			'post_image' => null,
			'post_category' => 1
		]);
		$response->assertRedirect('/posts/test-title3');
	}

	public function testUserCanDeleteHisPost(): void
	{
		$this->actingAs(self::$user1);

		$post = Post::factory()->create([
			'user_id' => self::$user1->id,
			'category_id' => self::$category->id
		]);

		$response = $this->delete('/posts/' . $post->slug);
		$response->assertRedirect('/posts');
	}

	public function testUserCannotDeleteOtherUsersPost(): void
	{
		$this->actingAs(self::$user1);

		$post = Post::factory()->create([
			'user_id' => self::$user2->id,
			'category_id' => self::$category->id
		]);

		$response = $this->delete('/posts/' . $post->slug);
		$response->assertForbidden();
	}

	public function testAdminCanDeleteOtherUsersPost(): void
	{
		$this->actingAs(self::$admin);

		$post = Post::factory()->create([
			'user_id' => self::$user1->id,
			'category_id' => self::$category->id
		]);

		$response = $this->delete('/posts/' . $post->slug);
		$response->assertRedirect('/posts');
	}
}
