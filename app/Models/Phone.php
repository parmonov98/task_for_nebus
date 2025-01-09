<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Phone extends Model
{
    protected $fillable = [
        'organization_id',
        'phone_number'
    ];

    /**
     * Get the organization that owns the phone
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}