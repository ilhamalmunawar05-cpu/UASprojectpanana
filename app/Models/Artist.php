<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bio',
        'specialization',
        'image',
        'email',
        'phone',
    ];

    public function artworks()
    {
        return $this->hasMany(Artwork::class);
    }
}
