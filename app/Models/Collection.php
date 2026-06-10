<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'year',
        'origin',
        'material',
        'dimensions',
        'collection_number',
        'category',
    ];
}