<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    protected $fillable = [
        'artwork_id',
        'start_date',
        'end_date',
        'starting_bid',
        'current_bid',
        'winner_id',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function artwork()
    {
        return $this->belongsTo(Artwork::class);
    }

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class)->orderBy('bid_amount', 'desc');
    }

    // Check if auction is active
    public function isActive()
    {
        return $this->status === 'active' 
            && now()->between($this->start_date, $this->end_date);
    }
}

