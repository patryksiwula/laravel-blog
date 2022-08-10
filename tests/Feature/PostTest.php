<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPostsCanBeRendered()
    {
        $response = $this->get('/posts');
        $response->assertOk();
    }

	public function testSinglePostCanBeRendered(): void
	{
		User::factory()->create();
		Category::factory()->create();
		$post = Post::factory()->create();
		$response = $this->get('/posts/' . $post->slug);
		$response->assertOk();
	}

	public function testUserCanDisplayTheEditFormOfHisPost(): void
	{
		/**
		 * @var \Illuminate\Contracts\Auth\Authenticatable
		 */
		$user = User::factory()->create();
		
		$this->actingAs($user);
		Category::factory()->create();

		$post = Post::factory()->create([
			'user_id' => $user->id
		]);

		$response = $this->get('/posts/' . $post->slug . '/edit');
		$response->assertOk();
	}

	public function testUserCannotDisplayTheEditFormOfOtherUsersPost(): void
	{
		/**
		 * @var \Illuminate\Contracts\Auth\Authenticatable
		 */
		$user1 = User::factory()->create();

		/**
		 * @var \Illuminate\Contracts\Auth\Authenticatable
		 */
		$user2 = User::factory()->create();

		$this->actingAs($user1);
		Category::factory()->create();

		$post = Post::factory()->create([
			'user_id' => $user2->id
		]);

		$response = $this->get('/posts/' . $post->slug . '/edit');
		$response->assertForbidden();
	}

	public function testUserCanEditHisPost(): void
	{
		/**
		 * @var \Illuminate\Contracts\Auth\Authenticatable
		 */
		$user = User::factory()->create();

		$this->actingAs($user);
		Category::factory()->create();

		$post = Post::factory()->create([
			'user_id' => $user->id
		]);

		$response = $this->patch('/posts/' . $post->slug, [
			'post_title' => 'Test title',
			'post_content' => 'Test content',
			'post_image' => null,
			'post_category' => 1
		]);
		
		$response->assertRedirect('/posts/test-title');
	}

	public function testUserCannotEditPostOfAnotherUser(): void
	{
		/**
		 * @var \Illuminate\Contracts\Auth\Authenticatable
		 */
		$user1 = User::factory()->create();

		/**
		 * @var \Illuminate\Contracts\Auth\Authenticatable
		 */
		$user2 = User::factory()->create();
		
		$this->actingAs($user1);
		Category::factory()->create();

		$post = Post::factory()->create([
			'user_id' => $user2->id
		]);

		$response = $this->patch('/posts/' . $post->slug);
		$response->assertForbidden();
	}
}
