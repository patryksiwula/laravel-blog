<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
	use RefreshDatabase;

    /**
     * Test if the user list is displayed correctly.
     *
     * @return void
     */
    public function test_user_list_can_be_rendered(): void
    {
		$user = User::factory()->create();
		$this->actingAs($user);
        $response = $this->get('/users');
        $response->assertStatus(200);
    }

	public function test_guests_cannot_view_user_list(): void
	{
        $response = $this->get('/users');
        $response->assertRedirect('/login');
	}

	public function test_normal_user_cannot_see_change_role_selects(): void
	{
		$user = User::factory()->create([
			'is_admin' => 0
		]);

		$this->actingAs($user);
		$response = $this->get('/users');
		$response->assertDontSee('checkbox');
	}

	public function test_admin_can_see_change_role_selects(): void
	{
		$user = User::factory()->create([
			'is_admin' => 1
		]);

		$this->actingAs($user);
		$response = $this->get('/users');
		$response->assertSee('checkbox');
	}

	public function test_user_profile_page_can_be_rendered(): void
	{
		$user = User::factory()->create();
		$this->actingAs($user);
        $response = $this->get('/users/' . $user->id);
        $response->assertStatus(200);
	}

	public function test_guests_cannot_view_profiles(): void
	{
		$user = User::factory()->create();
        $response = $this->get('/users/' . $user->id);
		$response->assertRedirect('/login');
	}

	public function test_edit_form_can_be_rendered(): void
	{
		$user = User::factory()->create();
		$this->actingAs($user);
		$response = $this->get('/users/' . $user->id . '/edit');
		$response->assertStatus(200);
	}

	public function test_normal_user_can_edit_self(): void
	{
		$user = User::factory()->create([
			'is_admin' => 0
		]);

		$this->actingAs($user);

		$response = $this->patch('/users/' . $user->id, [
			'name' => 'Test change name'
		]);

		$response->assertRedirect('/users/' . $user->id);
	}

	public function test_normal_user_cannot_edit_other_users(): void
	{
		$users = User::factory(2)->create([
			'is_admin' => 0
		]);

		$this->actingAs($users->get(0));

		$response = $this->patch('/users/' . $users->get(1)->id, [
			'name' => 'Test change name'
		]);

		$response->assertStatus(403);
	}

	public function test_admin_can_edit_users(): void
	{
		$admin = User::factory()->create([
			'is_admin' => 1
		]);

		$user = User::factory()->create([
			'is_admin' => 0
		]);

		$this->actingAs($admin);

		$response = $this->patch('/users/' . $user->id, [
			'name' => 'Test change name'
		]);

		$response->assertRedirect('/users/' . $user->id);
	}

	public function test_normal_user_cannot_delete_users(): void
	{
		$users = User::factory(2)->create([
			'is_admin' => 0
		]);

		$this->actingAs($users->get(0));
		$response = $this->delete('/users/' . $users->get(1)->id);
		$response->assertStatus(403);
	}

	public function test_admin_can_delete_users(): void
	{
		$admin = User::factory()->create([
			'is_admin' => 1
		]);

		$user = User::factory()->create([
			'is_admin' => 0
		]);

		$this->actingAs($admin);
		$response = $this->delete('/users/' . $user->id);
		$response->assertRedirect('/users');
	}
}