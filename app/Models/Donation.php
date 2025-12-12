<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'item_id',
        'donor_id',
        'submitted_at'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }
}
