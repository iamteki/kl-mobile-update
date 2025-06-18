<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'event_type_id',
        'service',
        'message',
        'ip_address',
        'user_agent',
        'status',
        'admin_notes',
        'read_at',
        'replied_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'replied_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    // Scopes
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    public function scopeNotArchived($query)
    {
        return $query->where('status', '!=', 'archived');
    }

    // Accessors
    public function getServiceNameAttribute()
    {
        if ($this->event_type_id) {
            return $this->eventType->name;
        }
        
        return $this->service === 'other' ? 'Other Event' : $this->service;
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'new' => 'danger',
            'read' => 'warning',
            'replied' => 'success',
            'archived' => 'gray',
            default => 'primary'
        };
    }

    public function getStatusIconAttribute()
    {
        return match($this->status) {
            'new' => 'heroicon-o-envelope',
            'read' => 'heroicon-o-eye',
            'replied' => 'heroicon-o-check-circle',
            'archived' => 'heroicon-o-archive-box',
            default => 'heroicon-o-question-mark-circle'
        };
    }

    // Methods
    public function markAsRead()
    {
        if ($this->status === 'new') {
            $this->update([
                'status' => 'read',
                'read_at' => now(),
            ]);
        }
    }

    public function markAsReplied()
    {
        $this->update([
            'status' => 'replied',
            'replied_at' => now(),
        ]);
    }

    public function archive()
    {
        $this->update(['status' => 'archived']);
    }
}