<?php

namespace App\Services;

use \App\Actions\GenerateThumbnail;
use \App\Models\User;
use \Illuminate\Http\UploadedFile;

class UserService
{
	/**
	 * Constructor method
	 *
	 * @param  \App\Actions\GenerateThumbnail $generateThumbnail
	 */
	public function __construct(private GenerateThumbnail $generateThumbnail) { }

	public function updateUser(int $id, string $name, ?string $website, ?string $github, ?UploadedFile $file): void
	{
		$user = User::find($id);

		// Only update the fields in the database if they have been changed
		if ($user->name !== $name)
			$user->name = $name;
		
		if ($user->website !== $website)
			$user->website = $website;

			if ($user->github !== $github)
				$user->github = $github;

		if ($file)
		{
			$image = $file;
			$fileName = date('d_m_Y_H_i') . $image->getClientOriginalName();
			$thumbnailSm = 'thumbnail_sm_' . $fileName;
			$thumbnailXs = 'thumbnail_xs_' . $fileName;
			$image->storeAs('public/uploads/profiles', $fileName);
			$image->storeAs('public/uploads/profiles/thumbnails_sm', $thumbnailSm);
			$image->storeAs('public/uploads/profiles/thumbnails_xs', $thumbnailXs);
			
			// Generate thumbnails
			$thumbnailPathSm = public_path('storage/uploads/profiles/thumbnails_sm/' . $thumbnailSm);
			$thumbnailPathXs = public_path('storage/uploads/profiles/thumbnails_xs/' . $thumbnailXs);
			$this->generateThumbnail->handle($thumbnailPathSm, 100, 100);
			$this->generateThumbnail->handle($thumbnailPathXs, 40, 40);

			$user->image_path = $fileName;
			$user->thumbnail_sm_path = $thumbnailSm;
			$user->thumbnail_xs_path = $thumbnailXs;
		}

		$user->save();
	}
}