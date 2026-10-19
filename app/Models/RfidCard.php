<?php

namespace App\Models;

use App\Models\RfidScan;
use Illuminate\Database\Eloquent\Model;

class RfidCard extends Model
{
    protected $fillable = ['uid', 'owner_name', 'owner_email', 'owner_phone', 'is_active'];

    public function scans()
    {
        return $this->hasMany(RfidScan::class);
    }
}
