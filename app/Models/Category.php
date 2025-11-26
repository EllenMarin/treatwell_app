<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the businesses in this category.
     */
    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'business_category')
            ->withTimestamps();
    }

    /**
     * Get the plans in this category.
     */
    public function plans()
    {
        return $this->hasMany(Plan::class);
    }
}

