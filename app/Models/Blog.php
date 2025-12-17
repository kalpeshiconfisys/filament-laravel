<?php

// app/Models/Blog.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'description', 'thumbnail', 'featured_image',
        'meta_title', 'meta_description', 'published_at', 'status', 'is_featured',
        'view_count', 'reading_time', 'video_url', 'location', 'created_by'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'blog_category');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
