<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class CommentTest extends TestCase
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
	protected static ?Post $post = null;

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

			self::$post = Post::factory()->create([
				'category_id' => self::$category->id
			]);
		}
	}
    public function testCreateCommentFormCanBeRendered(): void
    {
		$this->actingAs(self::$user1);
        $response = $this->get('/posts/' . self::$post->slug . '/comments/create');
        $response->assertOk();
    }

	public function testUserCanCreateComment(): void
	{
		$this->actingAs(self::$user1);

		$response = $this->post('/posts/' . self::$post->slug . '/comments', [
			'comment_content' => 'Test comment'
		]);

		$response->assertRedirect('/posts/' . self::$post->slug);
	}

	public function testUserCanViewEditFormOfHisComment(): void
	{
		$this->actingAs(self::$user1);
		$comment = $this->createTestComment(null, self::$user1->id);
		$response = $this->get('/posts/' . $comment->commentable->slug . '/comments/' . $comment->id . '/edit');
		$response->assertOk();
	}

	public function testUserCannotViewEditFormOfOtherUsersComment(): void
	{
		$this->actingAs(self::$user1);
		$comment = $this->createTestComment(null, self::$user2->id);
		$response = $this->get('/posts/' . $comment->commentable->slug . '/comments/' . $comment->id . '/edit');
		$response->assertForbidden();
	}

	public function testUserCanEditHisComment(): void
	{
		$this->actingAs(self::$user1);
		$comment = $this->createTestComment(null, self::$user1->id);

		$response = $this->patch('/posts/' . $comment->commentable->slug . '/comments/' . $comment->id, [
			'comment_content' => 'Content after update'
		]);

		$response->assertRedirect('/posts/' . $comment->commentable->slug);
	}

	public function testUserCannotEditOtherUsersComment(): void
	{
		$this->actingAs(self::$user1);
		$comment = $this->createTestComment(null, self::$user2->id);

		$response = $this->patch('/posts/' . $comment->commentable->slug . '/comments/' . $comment->id, [
			'comment_content' => 'Content after update'
		]);

		$response->assertForbidden();
	}

	public function testAdminCanEditOtherUsersComment(): void
	{
		$this->actingAs(self::$admin);
		$comment = $this->createTestComment(null, self::$user1->id);

		$response = $this->patch('/posts/' . $comment->commentable->slug . '/comments/' . $comment->id, [
			'comment_content' => 'Content after update'
		]);

		$response->assertRedirect('/posts/' . $comment->commentable->slug);
	}

	public function testUserCanDeleteHisComment(): void
	{
		$this->actingAs(self::$user1);
		$comment = $this->createTestComment(null, self::$user1->id);

		// Get the post so the user can be redirected back after comment is deleted
		$post = $comment->commentable;
		$response = $this->delete('/posts/' . $comment->commentable->slug . '/comments/' . $comment->id);
		$response->assertRedirect('/posts/' . $post->slug);
	}

	public function testUserCannotDeleteOtherUsersComment(): void
	{
		$this->actingAs(self::$user1);
		$comment = $this->createTestComment(self::$user2->id, self::$user2->id);
		$response = $this->delete('/posts/' . $comment->commentable->slug . '/comments/' . $comment->id);
		$response->assertForbidden();
	}

	public function testPostAuthorCanDeleteOtherUsersComment(): void
	{
		$this->actingAs(self::$user1);
		$comment = $this->createTestComment(self::$user1->id, self::$user2->id);

		// Get the post so the user can be redirected back after comment is deleted
		$post = $comment->commentable;
		$response = $this->delete('/posts/' . $comment->commentable->slug . '/comments/' . $comment->id);
		$response->assertRedirect('/posts/' . $post->slug);
	}

	public function testAdminCanDeleteOtherUsersComment(): void
	{
		$this->actingAs(self::$admin);
		$comment = $this->createTestComment(null, self::$user1->id);

		// Get the post so the user can be redirected back after comment is deleted
		$post = $comment->commentable;
		$response = $this->delete('/posts/' . $comment->commentable->slug . '/comments/' . $comment->id);
		$response->assertRedirect('/posts/' . $post->slug);
	}

	protected function createTestComment(?int $postAuthorId, int $commentAuthorId): Comment
	{
		if (!is_null($postAuthorId))
			self::$post->update(['user_id' => $postAuthorId]);

		$comment = Comment::factory()->create([
			'user_id' => $commentAuthorId,
			'commentable_id' => self::$post->id
		]);

		return $comment;
	}
}
