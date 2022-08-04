<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
		'slug',
        'content',
		'image_path',
		'thumbnail_path',
		'user_id',
		'category_id'
    ];

	public function getRouteKeyName()
	{
		return 'slug';
	}
	
	/**
	 * Get the user which the post belongs to
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
	
	/**
	 * Get the user who has most recently updated the post
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function updatedByUser(): BelongsTo
	{
		return $this->belongsTo(User::class, 'updated_by', 'id');
	}
	
	/**
	 * Get the comments to the post
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function comments(): MorphMany
	{
		return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
	}
}
