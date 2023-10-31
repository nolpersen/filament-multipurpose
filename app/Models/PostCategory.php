<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PostCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image'
    ];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_has_categories', 'post_category_id', 'post_id');
    }
}
