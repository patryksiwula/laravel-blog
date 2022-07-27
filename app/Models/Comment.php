<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id',
		'post_id',
		'content'
	];
	
	/**
	 * Get the user which the comment belongs to
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
	
	/**
	 * Get the post which the comment belongs to
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function post(): BelongsTo
	{
		return $this->belongsTo(Post::class);
	}
	
	/**
	 * Get the replies to the comment
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function replies(): HasMany
	{
		return $this->hasMany(Comment::class, 'parent_id', 'id');
	}
	
	/**
	 * Get the comment which the reply belongs to
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function parent(): BelongsTo
	{
		return $this->belongsTo(Comment::class, 'parent_id');
	}
}
