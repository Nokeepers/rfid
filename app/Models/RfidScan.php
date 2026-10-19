<?php

namespace App\Models;

use App\Models\RfidCard;
use Illuminate\Database\Eloquent\Model;

class RfidScan extends Model
{
    protected $fillable = ['uid', 'rfid_card_id', 'device_id', 'status', 'ip_address'];

    public function rfidCard()
    {
        return $this->belongsTo(RfidCard::class);
    }
}
