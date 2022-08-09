<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use Illuminate\Contracts\View\View;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
		$users = User::paginate(15);

        return view('users.index', ['users' => $users]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\View\View
     */
    public function show(User $user): View
    {
		$posts = $user->posts()->with('user')->paginate(5);

        return view('users.profile', ['user' => $user, 'posts' => $posts]);
    }

	/**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(User $user): View
    {
		$this->authorize('update', $user);

        return view('users.edit', ['user' => $user]);
    }

	/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user, UserService $userService): RedirectResponse
    {
		$this->authorize('update', $user);
		
		$userService->updateUser(
			$user->id,
			$request->input('user_name'),
			$request->input('user_website'),
			$request->input('user_github'),
			$request->file('user_image')
		);

		return redirect()->route('users.show', [
			'user' => $user
		])->with('message', 'profile_updated');
	}

	/**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
		$this->authorize('delete', $user);
        $user->delete();

		return redirect()->route('users.index')
			->with('message', 'user_deleted');
    }
}
