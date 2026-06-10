<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'image',
        'thumbnail',
        'author_id',
        'artwork_id',
        'category',
        'tags',
        'views',
        'is_published',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views' => 'integer',
        'tags' => 'array', // Jika tags berupa JSON
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Boot method untuk handle event model
     */
    protected static function boot()
    {
        parent::boot();
        
        // Event: sebelum save, convert empty string ke null untuk artwork_id
        static::saving(function ($article) {
            // Convert empty string to null untuk artwork_id
            if ($article->artwork_id === '' || $article->artwork_id === '0' || empty($article->artwork_id)) {
                $article->artwork_id = null;
            }
            
            // Auto generate slug jika belum ada
            if (empty($article->slug) && !empty($article->title)) {
                $article->slug = \Illuminate\Support\Str::slug($article->title);
            }
            
            // Auto generate excerpt dari content jika belum ada
            if (empty($article->excerpt) && !empty($article->content)) {
                $article->excerpt = \Illuminate\Support\Str::limit(strip_tags($article->content), 200);
            }
        });
    }

    /**
     * Relasi: Article belongs to Author (User)
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Relasi: Article belongs to Artwork (optional)
     */
    public function artwork()
    {
        return $this->belongsTo(Artwork::class, 'artwork_id');
    }

    /**
     * Relasi: Article has many Comments
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Scope: Hanya artikel yang published
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope: Artikel terbaru
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope: Filter berdasarkan kategori
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope: Search artikel
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhere('content', 'like', '%' . $search . '%')
              ->orWhere('excerpt', 'like', '%' . $search . '%');
        });
    }

    /**
     * Accessor: Get full image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-article.jpg');
    }

    /**
     * Accessor: Get thumbnail URL
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        return $this->image_url;
    }

    /**
     * Accessor: Get reading time (menit)
     */
    public function getReadingTimeAttribute()
    {
        $words = str_word_count(strip_tags($this->content));
        $minutes = ceil($words / 200); // Asumsi 200 kata per menit
        return $minutes;
    }

    /**
     * Accessor: Get formatted published date
     */
    public function getPublishedDateAttribute()
    {
        if ($this->published_at) {
            return $this->published_at->format('d M Y');
        }
        return $this->created_at->format('d M Y');
    }

    /**
     * Mutator: Set slug otomatis dari title
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        
        // Auto generate slug jika belum ada
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = \Illuminate\Support\Str::slug($value);
        }
    }

    /**
     * Increment views count
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Check if article is published
     */
    public function isPublished()
    {
        return $this->is_published && 
               ($this->published_at ? $this->published_at->isPast() : true);
    }

    /**
     * Get category label
     */
    public function getCategoryLabelAttribute()
    {
        $labels = [
            'kritik' => 'Kritik Seni',
            'ulasan' => 'Ulasan Pameran',
            'berita' => 'Berita Seni',
            'tutorial' => 'Tutorial',
            'wawancara' => 'Wawancara',
            'opini' => 'Opini',
        ];

        return $labels[$this->category] ?? ucfirst($this->category);
    }

    /**
     * Get related articles (berdasarkan category atau tags)
     */
    public function getRelatedArticles($limit = 3)
    {
        return self::where('id', '!=', $this->id)
                   ->where('category', $this->category)
                   ->where('is_published', true)
                   ->latest()
                   ->limit($limit)
                   ->get();
    }
}