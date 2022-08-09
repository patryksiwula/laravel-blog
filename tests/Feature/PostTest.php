<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_posts_can_be_rendered()
    {
        $response = $this->get('/posts');
        $response->assertStatus(200);
    }

	public function test_single_post_can_be_rendered(): void
	{
		User::factory()->create();
		Category::factory()->create();
		$post = Post::factory()->create();
		$response = $this->get('/posts/' . $post->slug);
		$response->assertStatus(200);
	}

	public function test_user_can_display_the_edit_form_of_his_post(): void
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
		$response->assertStatus(200);
	}

	public function test_user_cannot_display_the_edit_form_of_other_users_post(): void
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
		$response->assertStatus(403);
	}

	public function test_user_can_edit_his_post(): void
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
			'post_title' => 'Test',
			'post_content' => 'test',
			'post_category' => 1,
			'file' => null
		]);
		
		$response->assertRedirect('/posts/test');
	}

	public function test_user_cannot_edit_post_of_another_user(): void
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
		$response->assertStatus(403);
	}
}
