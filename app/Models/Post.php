<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'short_desc',
        'content',
        'author',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'seo_url',
        'featured_image'
    ];

    public function post_author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }

    public function post_categories(): BelongsToMany
    {
        return $this->belongsToMany(PostCategory::class, 'post_has_categories', 'post_id', 'post_category_id');
    }
}
