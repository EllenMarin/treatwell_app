<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'business_id',
        'customer_id',
        'plan_id',
        'staff_id',
        'booking_date',
        'booking_time',
        'duration',
        'status',
        'price',
        'currency',
        'deposit_paid',
        'deposit_amount',
        'total_paid',
        'payment_method',
        'customer_name',
        'customer_email',
        'customer_phone',
        'notes',
        'cancellation_reason',
        'cancelled_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'booking_date' => 'date',
        'booking_time' => 'datetime',
        'price' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'total_paid' => 'decimal:2',
        'deposit_paid' => 'boolean',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Booking status constants.
     */
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_NO_SHOW = 'no_show';

    /**
     * Get the business for this booking.
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Get the customer for this booking.
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the plan/service for this booking.
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get the staff member assigned to this booking.
     */
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    /**
     * Scope a query to only include pending bookings.
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope a query to only include confirmed bookings.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_CONFIRMED);
    }

    /**
     * Scope a query to only include completed bookings.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope a query to only include cancelled bookings.
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', self::STATUS_CANCELLED);
    }

    /**
     * Scope a query to filter bookings by date.
     */
    public function scopeForDate($query, $date)
    {
        return $query->whereDate('booking_date', $date);
    }

    /**
     * Scope a query to filter bookings for today.
     */
    public function scopeToday($query)
    {
        return $query->whereDate('booking_date', Carbon::today());
    }

    /**
     * Scope a query to filter upcoming bookings.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('booking_date', '>=', Carbon::today())
            ->whereIn('status', [self::STATUS_PENDING, self::STATUS_CONFIRMED])
            ->orderBy('booking_date')
            ->orderBy('booking_time');
    }

    /**
     * Check if booking can be cancelled.
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_CONFIRMED])
            && $this->booking_date >= Carbon::today();
    }

    /**
     * Cancel the booking.
     */
    public function cancel(string $reason = null): bool
    {
        if (!$this->canBeCancelled()) {
            return false;
        }

        $this->update([
            'status' => self::STATUS_CANCELLED,
            'cancellation_reason' => $reason,
            'cancelled_at' => now(),
        ]);

        return true;
    }

    /**
     * Confirm the booking.
     */
    public function confirm(): bool
    {
        if ($this->status !== self::STATUS_PENDING) {
            return false;
        }

        $this->update(['status' => self::STATUS_CONFIRMED]);

        return true;
    }

    /**
     * Complete the booking.
     */
    public function complete(): bool
    {
        if ($this->status !== self::STATUS_CONFIRMED) {
            return false;
        }

        $this->update(['status' => self::STATUS_COMPLETED]);

        return true;
    }

    /**
     * Get formatted booking date and time.
     */
    public function getFormattedDateTimeAttribute()
    {
        return $this->booking_date->format('M d, Y') . ' at ' . $this->booking_time->format('H:i');
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'yellow',
            self::STATUS_CONFIRMED => 'blue',
            self::STATUS_COMPLETED => 'green',
            self::STATUS_CANCELLED => 'red',
            self::STATUS_NO_SHOW => 'gray',
            default => 'gray',
        };
    }
}

