<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Validation\ValidationException;

class Category extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
        'level'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($category) {
            $category->validateLevel();
        });
    }

    /**
     * Get the parent category
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the child categories
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get organizations belonging to this category
     */
    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class);
    }

    /**
     * Calculate and validate the level before saving
     */
    protected function validateLevel(): void
    {
        if ($this->parent_id) {
            $parent = Category::find($this->parent_id);
            $this->level = $parent ? $parent->level + 1 : 1;
        } else {
            $this->level = 1;
        }

        if ($this->level > 3) {
            throw ValidationException::withMessages([
                'level' => ['Categories cannot be nested deeper than 3 levels.']
            ]);
        }
    }

    /**
     * Get all descendants of the category
     */
    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    /**
     * Get all ancestors of the category
     */
    public function ancestors()
    {
        return $this->parent()->with('ancestors');
    }
}