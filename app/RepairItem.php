<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RepairItem extends Model
{
    protected $fillable = [
        'repair_id',
        'mc_type',
        'serial_no',
        'capacity',
    ];

    public static function scopeRepair($query, $repairId)
    {
        return $query->where('repair_id', '=', $repairId);

    }
}
