<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Intervention\Image\ImageManagerStatic as Image;

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
    public function update(Request $request, User $user): RedirectResponse
    {
		$this->authorize('update', $user);

		$validate = $request->validate([
			'user_image' => 'image|mimes:png,jpg,bmp,gif|dimensions:width=200,height=200',
			'user_name' => 'min:6|max:64',
			'user_website' => 'url|nullable',
			'user_github' => 'url|nullable'
		]);
		
		// Only update the fields in the database if they have been changed
		if ($user->name !== $request->input('user_name'))
			$user->name = $request->input('user_name');
		
		if ($user->website !== $request->input('user_website'))
			$user->website = $request->input('user_website');

			if ($user->github !== $request->input('user_github'))
				$user->github = $request->input('user_github');

		if ($request->file('user_image'))
		{
			$image = $request->file('user_image');
			$fileName = date('d_m_Y_H_i') . $image->getClientOriginalName();
			$thumbnailSm = 'thumbnail_sm_' . $fileName;
			$thumbnailXs = 'thumbnail_xs_' . $fileName;
			$image->storeAs('public/uploads/profiles', $fileName);
			$image->storeAs('public/uploads/profiles/thumbnails_sm', $thumbnailSm);
			$image->storeAs('public/uploads/profiles/thumbnails_xs', $thumbnailXs);
			
			// Generate thumbnails
			$thumbnailPathSm = public_path('storage/uploads/profiles/thumbnails_sm/' . $thumbnailSm);
			$thumbnailPathXs = public_path('storage/uploads/profiles/thumbnails_xs/' . $thumbnailXs);
			$this->generateThumbnail($thumbnailPathSm, 100, 100);
			$this->generateThumbnail($thumbnailPathXs, 40, 40);

			$user->image_path = $fileName;
			$user->thumbnail_sm_path = $thumbnailSm;
			$user->thumbnail_xs_path = $thumbnailXs;
		}

		$user->save();

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

	/**
	 * Generate a thumbnail of specified size
	 *
	 * @param  string $path path of thumbnail
	 * @param  int $width
	 * @param  int $height
	 * @return void
	 */	
	public function generateThumbnail(string $path, int $width, int $height): void
	{
    	$img = Image::make($path)->resize($width, $height)
			->save($path);
	}
}
