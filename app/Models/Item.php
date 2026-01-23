<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'category_id',
        'donor_id',
        'name',
        'description',
        'condition',
        'photo',
        'photo_data',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }

    public function donation()
    {
        return $this->hasOne(Donation::class);
    }
}
