<?php
namespace App\Actions;

use \Intervention\Image\ImageManagerStatic as Image;

class GenerateThumbnail
{
	/**
	 * Generate a thumbnail of specified size
	 *
	 * @param  string $path path of thumbnail
	 * @param  int $width
	 * @param  int $height
	 * @return void
	 */	
	public function handle(string $path, int $width, int $height): void
	{
    	$img = Image::make($path)->resize($width, $height)
			->save($path);
	}
}