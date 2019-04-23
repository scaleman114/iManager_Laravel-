<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//contract_type is an integer but we use an Enum declared in App\Enums
class Contract extends Model
{
    protected $fillable = [
        'contract_id',
        'contract_customer',
        'contract_premium',
        'contract_startdate',
        'contract_terms',
        'contract_notes',
        'contract_premium',
        'contract_type',

    ];
}