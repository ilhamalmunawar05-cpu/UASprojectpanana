<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'year',
        'medium',
        'dimensions',
        'price',
        'artist_id',
        'status',
    ];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function exhibitions()
    {
        return $this->belongsToMany(Exhibition::class, 'artwork_exhibition');
    }

    public function auction()
    {
        return $this->hasOne(Auction::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
