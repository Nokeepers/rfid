<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RfidCard extends Model
{
    protected $fillable = [
        'uid',
        'owner_name',
        'owner_email',
        'is_active',
    ];
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
    public function scanRecords()
    {
        return $this->hasMany(ScanRecord::class);
    }
}
