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
	private static ?User $user1 = null;

	/**
	 * @var \Illuminate\Contracts\Auth\Authenticatable
	 */
	private static ?User $user2 = null;

	/**
	 * @var \Illuminate\Contracts\Auth\Authenticatable
	 */
	private static ?User $admin = null;

	private static ?Category $category = null;
	private static ?Post $post = null;

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
		$comment = $this->createTestComment(null, self::$user1->id, null);
		$response = $this->get('/posts/' . $comment->commentable->slug . '/comments/' . $comment->id . '/edit');
		$response->assertOk();
	}

	public function testUserCannotViewEditFormOfOtherUsersComment(): void
	{
		$this->actingAs(self::$user1);
		$comment = $this->createTestComment(null, self::$user2->id, null);
		$response = $this->get('/posts/' . $comment->commentable->slug . '/comments/' . $comment->id . '/edit');
		$response->assertForbidden();
	}

	public function testUserCanEditHisComment(): void
	{
		$this->actingAs(self::$user1);
		$comment = $this->createTestComment(null, self::$user1->id, null);

		$response = $this->patch('/posts/' . $comment->commentable->slug . '/comments/' . $comment->id, [
			'comment_content' => 'Content after update'
		]);

		$response->assertRedirect('/posts/' . $comment->commentable->slug);
	}

	public function testUserCannotEditOtherUsersComment(): void
	{
		$this->actingAs(self::$user1);
		$comment = $this->createTestComment(null, self::$user2->id, null);

		$response = $this->patch('/posts/' . $comment->commentable->slug . '/comments/' . $comment->id, [
			'comment_content' => 'Content after update'
		]);

		$response->assertForbidden();
	}

	public function testAdminCanEditOtherUsersComment(): void
	{
		$this->actingAs(self::$admin);
		$comment = $this->createTestComment(null, self::$user1->id, null);

		$response = $this->patch('/posts/' . $comment->commentable->slug . '/comments/' . $comment->id, [
			'comment_content' => 'Content after update'
		]);

		$response->assertRedirect('/posts/' . $comment->commentable->slug);
	}

	public function testUserCanDeleteHisComment(): void
	{
		$this->actingAs(self::$user1);
		$comment = $this->createTestComment(null, self::$user1->id, null);

		// Get the post so the user can be redirected back after comment is deleted
		$post = $comment->commentable;
		$response = $this->delete('/posts/' . $comment->commentable->slug . '/comments/' . $comment->id);
		$response->assertRedirect('/posts/' . $post->slug);
	}

	public function testUserCannotDeleteOtherUsersComment(): void
	{
		$this->actingAs(self::$user1);
		$comment = $this->createTestComment(self::$user2->id, self::$user2->id, null);
		$response = $this->delete('/posts/' . $comment->commentable->slug . '/comments/' . $comment->id);
		$response->assertForbidden();
	}

	public function testPostAuthorCanDeleteOtherUsersComment(): void
	{
		$this->actingAs(self::$user1);
		$comment = $this->createTestComment(self::$user1->id, self::$user2->id, null);

		// Get the post so the user can be redirected back after comment is deleted
		$post = $comment->commentable;
		$response = $this->delete('/posts/' . $comment->commentable->slug . '/comments/' . $comment->id);
		$response->assertRedirect('/posts/' . $post->slug);
	}

	public function testAdminCanDeleteOtherUsersComment(): void
	{
		$this->actingAs(self::$admin);
		$comment = $this->createTestComment(null, self::$user1->id, null);

		// Get the post so the user can be redirected back after comment is deleted
		$post = $comment->commentable;
		$response = $this->delete('/posts/' . $comment->commentable->slug . '/comments/' . $comment->id);
		$response->assertRedirect('/posts/' . $post->slug);
	}

	public function testUserCanCreateReply(): void
	{
		$this->actingAs(self::$user1);
		$comment = $this->createTestComment(null, self::$user1->id, null);

		$response = $this->post('/posts/' . self::$post->slug . '/comments', [
			'comment_content' => 'Test comment',
			'comment' => $comment->id
		]);

		$response->assertRedirect('/posts/' . self::$post->slug);

	}

	public function testUserCanCreateReplyToReply(): void
	{
		$this->actingAs(self::$user1);
		$comment = $this->createTestComment(null, self::$user1->id, null);
		$reply = $this->createTestComment(null, self::$user1->id, $comment);

		$response = $this->post('/posts/' . self::$post->slug . '/comments', [
			'comment_content' => 'Test comment',
			'comment' => $reply->id
		]);

		$response->assertRedirect('/posts/' . self::$post->slug);
	}

	private function createTestComment(?int $postAuthorId, int $commentAuthorId, ?Comment $parent): Comment
	{
		if (!is_null($postAuthorId))
			self::$post->update(['user_id' => $postAuthorId]);

		$fill = [
			'user_id' => $commentAuthorId,
			'commentable_id' => self::$post->id
		];

		if (!is_null($parent))
			$fill['parent_id'] = $parent->id;

		$comment = Comment::factory()->create($fill);
		return $comment;
	}
}
