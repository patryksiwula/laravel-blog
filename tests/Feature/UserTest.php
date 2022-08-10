<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
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
		}
	}

    public function testUserListCanBeRendered(): void
    {
		$this->actingAs(self::$user1);
        $response = $this->get('/users');
        $response->assertOk();
    }

	public function testGuestCannotViewUserList(): void
	{
        $response = $this->get('/users');
        $response->assertRedirect('/login');
	}

	public function testNormalUserCannotSeeChangeRoleSelect(): void
	{
		$this->actingAs(self::$user1);
		$response = $this->get('/users');
		$response->assertDontSee('checkbox');
	}

	public function testAdminCanSeeChangeRoleSelect(): void
	{
		$this->actingAs(self::$admin);
		$response = $this->get('/users');
		$response->assertSee('checkbox');
	}

	public function testUserProfilePageCanBeRendered(): void
	{
		$this->actingAs(self::$user1);
        $response = $this->get('/users/' . self::$user1->id);
        $response->assertOk();
	}

	public function testEditFormCanBeRendered(): void
	{
		$this->actingAs(self::$user1);
		$response = $this->get('/users/' . self::$user1->id . '/edit');
		$response->assertOk();
	}

	public function testNormalUserCanEditSelf(): void
	{
		$this->actingAs(self::$user1);

		$response = $this->patch('/users/' . self::$user1->id, [
			'name' => 'Test change name'
		]);

		$response->assertRedirect('/users/' . self::$user1->id);
	}

	public function testNormalUserCannotEditOtherUsers(): void
	{
		$this->actingAs(self::$user1);

		$response = $this->patch('/users/' . self::$user2->id, [
			'name' => 'Test change name'
		]);

		$response->assertForbidden();
	}

	public function testAdminCanEditUsers(): void
	{
		$this->actingAs(self::$admin);

		$response = $this->patch('/users/' . self::$user1->id, [
			'name' => 'Test change name'
		]);

		$response->assertRedirect('/users/' . self::$user1->id);
	}

	public function testNormalUserCannotDeleteUsers(): void
	{
		$this->actingAs(self::$user1);
		$response = $this->delete('/users/' . self::$user2->id);
		$response->assertForbidden();
	}

	public function testAdminCanDeleteUsers(): void
	{
		$this->actingAs(self::$admin);
		$response = $this->delete('/users/' . self::$user1->id);
		$response->assertRedirect('/users');
	}
}
