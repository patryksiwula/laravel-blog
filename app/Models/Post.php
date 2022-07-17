<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'content',
		'image_path',
		'thumbnail_path',
		'user_id'
    ];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function updatedByUser(): HasOne
	{
		return $this->hasOne(User::class, 'id', 'updated_by');
	}
}
