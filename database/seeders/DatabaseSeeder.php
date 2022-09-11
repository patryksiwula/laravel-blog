<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
		User::firstOrCreate(
			['name' => 'Test Admin'],
			['email' => 'admin@example.com'],
			['email_verified_at' => now()],
			['password' => Hash::make('admin123')],
			['remember_token' => Str::random(10)],
			['is_admin' => 1]
		);

		User::factory(5)->create();

		Category::create(['name' => 'Category 1', 'slug' => 'category-1']);
		Category::create(['name' => 'Category 2', 'slug' => 'category-2']);
		Category::create(['name' => 'Category 3', 'slug' => 'category-3']);
		Category::create(['name' => 'Category 4', 'slug' => 'category-4']);
		Category::create(['name' => 'Category 5', 'slug' => 'category-5']);

		Post::factory(30)->create();
		Comment::factory(60)->create();
    }
}
