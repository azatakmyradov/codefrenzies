<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class Post extends Model implements Sitemapable, Feedable
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['author:id,name'];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function toSitemapTag(): Url|string|array
    {
        return route('posts.show', $this);
    }

    public function getLinkAttribute(): string
    {
        return route('posts.show', [
            'post' => $this->slug
        ]);
    }

    public static function getFeedItems()
    {
        return static::all();
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($this->seo_description)
            ->updated($this->updated_at)
            ->link($this->link)
            ->authorName($this->author->name);
    }
}
