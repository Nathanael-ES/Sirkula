<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    protected $fillable = ['name','phone','address'];

    public function distributions()
    {
        return $this->hasMany(Distribution::class);
    }
}
