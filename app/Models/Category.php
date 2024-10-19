<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
    ];

    /**
     * Automatically set the slug when name is set.
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;

        // Hanya mengatur ulang slug jika nama berubah
        if (!isset($this->attributes['slug']) || $this->attributes['slug'] !== Str::slug($value)) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    /**
     * Get the route key name for Laravel model binding.
     * This allows using slug in the route instead of ID.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Relationship: A category has many news.
     */
    public function news()
    {
        return $this->hasMany(News::class);
    }

    /**
     * Accessor for icon attribute.
     * This can be useful if you need to get a full URL or modify the path.
     */
    public function getIconAttribute($value)
    {
        return asset('storage/icons/' . $value);
    }
}
