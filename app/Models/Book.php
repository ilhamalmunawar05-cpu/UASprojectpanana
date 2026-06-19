<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'publisher',
        'year',
        'isbn',
        'category_id',
        'rack',
        'stock',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('bookmaster/img/book.jpg');
        }

        if (preg_match('/^https?:\/\//i', $this->image)) {
            return $this->image;
        }

        if (file_exists(public_path($this->image))) {
            return asset($this->image);
        }

        return asset('storage/' . $this->image);
    }
}
