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

    public function distribution()
    {
        return $this->hasOne(Distribution::class);
    }
}
