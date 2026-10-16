<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'name',
        'mac_address',
        'last_seen_at',
        'is_online',
    ];
    protected function casts(): array
    {
        return [
            'last_seen_at' => 'datetime',
            'is_online' => 'boolean',
        ];
    }
    public function getIsOnlineAttribute()
    {
        return $this->last_seen_at && $this->last_seen_at->diffInMinutes(now()) < 5;
    }
}
