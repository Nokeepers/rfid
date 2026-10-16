<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScanRecord extends Model
{
    protected $fillable = [
        'rfid_cards_id',
        'device_id',
        'scanned_at',
    ];
    protected function casts(): array
    {
        return [
            'scanned_at' => 'datetime',
        ];
    }
    public function rfidCard()
    {
        return $this->belongsTo(RfidCard::class);
    }
    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
