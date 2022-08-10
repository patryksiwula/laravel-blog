<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
		$title = $this->faker->unique()->sentence();

        return [
            'title' => $title,
			'slug' => Str::slug($title),
			'content' => $this->faker->paragraphs(20, true),
			'image_path' => $this->faker->imageUrl(860, 300, null, false, 'Post', true),
			'thumbnail_path' => $this->faker->imageUrl(368, 240, null, false, 'Post', true),
			'user_id' => User::all('id')->random(),
			'category_id' => Category::all('id')->random()
        ];
    }
}
