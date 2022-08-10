<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::all('id')->random(),
			'commentable_id' => Post::all('id')->random(),
			'commentable_type' => 'App\Models\Post',
			'content' => $this->faker->paragraphs(1, true)
        ];
    }
}
