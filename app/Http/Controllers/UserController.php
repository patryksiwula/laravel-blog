<?php

namespace App\Http\Controllers;

use App\Actions\GenerateThumbnail;
use Illuminate\Http\Request;
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
		$this->authorize('viewAny', User::class);
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
    public function update(Request $request, User $user, UserService $userService, GenerateThumbnail $generateThumbnail): RedirectResponse
    {
		$this->authorize('update', $user);

		$validate = $request->validate([
			'user_image' => 'image|mimes:png,jpg,bmp,gif|dimensions:width=200,height=200',
			'user_name' => 'min:6|max:64',
			'user_website' => 'url|nullable',
			'user_github' => 'url|nullable'
		]);
		
		$userService->updateUser(
			$user->id,
			$request->input('user_name'),
			$request->input('user_website'),
			$request->input('user_github'),
			$request->file('user_image'),
			$generateThumbnail
		);

		return redirect()->route('users.show', [
			'user' => $user
		])->withMessage('message', 'profile_updated');
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
			->withMessage('message', 'user_deleted');
    }
}
