<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    protected $fillable = [
        'item_id',
        'recipient_id',
        'volunteer_id',
        'distributed_at',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function volunteer()
    {
        return $this->belongsTo(User::class, 'volunteer_id');
    }

    public function recipient()
    {
        return $this->belongsTo(Recipient::class);
    }
}
