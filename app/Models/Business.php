<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'email',
        'address',
        'city',
        'postal_code',
        'country',
        'phone',
        'description',
        'opening_hours',
        'images',
        'latitude',
        'longitude',
        'website',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'opening_hours' => 'array',
        'images' => 'array',
        'is_active' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Get the owner of the business.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the plans/services offered by the business.
     */
    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    /**
     * Get the bookings for the business.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the categories that the business belongs to.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'business_category')
            ->withTimestamps();
    }

    /**
     * Get the staff members of the business.
     */
    public function staff()
    {
        return $this->belongsToMany(User::class, 'business_staff')
            ->withPivot('role', 'is_active')
            ->withTimestamps();
    }

    /**
     * Scope a query to only include active businesses.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the primary image URL.
     */
    public function getPrimaryImageAttribute()
    {
        return $this->images[0] ?? null;
    }
}
