<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(User $user): View
    {
        return view('users.edit', ['user' => $user]);
    }

	/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
		return redirect()->route('users.show')
			->with([
				'user' => $user,
				'message' => 'profile_updated'
			]);
	}
}
