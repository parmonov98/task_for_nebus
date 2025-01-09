<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Building extends Model
{
    protected $fillable = [
        'address',
        'latitude',
        'longitude'
    ];

    /**
     * Get the organizations in this building
     */
    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }
}