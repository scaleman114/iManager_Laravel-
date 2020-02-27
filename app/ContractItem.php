<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractItem extends Model
{
    protected $fillable = [
        'contract_id',
        'mc_type',
        'serial_no',
        'capacity',
        'increment',
        'tolerance',
    ];

    public static function scopeContract($query, $contractId)
    {
        return $query->where('contract_id', '=', $contractId);

    }

    public function contract()
    {
        return $this->belongsTo('App\Contract');
    }
}