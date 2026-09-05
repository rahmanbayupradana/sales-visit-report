<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VisitType extends Model
{
    //
     protected $fillable = [
        'name',
        'description',
    ];

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }
}
