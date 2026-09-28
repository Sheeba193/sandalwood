<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'keep_updated',
        'ip_address',
        'user_agent',
        'status',
        'read_at',
        'replied_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'keep_updated' => 'boolean',
        'read_at' => 'datetime',
        'replied_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Mark the submission as read.
     */
    public function markAsRead(): void
    {
        if ($this->read_at === null) {
            $this->update(['read_at' => now()]);
        }
    }

    /**
     * Mark the submission as replied.
     */
    public function markAsReplied(): void
    {
        $this->update(['replied_at' => now()]);
    }

    /**
     * Check if the submission has been read.
     */
    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    /**
     * Check if the submission has been replied to.
     */
    public function isReplied(): bool
    {
        return $this->replied_at !== null;
    }

    /**
     * Scope a query to only include pending submissions.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include read submissions.
     */
    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    /**
     * Scope a query to only include unread submissions.
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Get the full name with proper formatting.
     */
    public function getFullNameAttribute($value): string
    {
        return ucwords(strtolower($value));
    }

    /**
     * Get a formatted phone number.
     */
    public function getFormattedPhoneAttribute(): string
    {
        // Format phone number (customize as needed)
        return $this->phone;
    }
}
