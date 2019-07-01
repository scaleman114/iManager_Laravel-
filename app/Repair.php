<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    protected $fillable = [

        'repair_customer',
        'date',
        'repair_type',
        'min_charge',
        'notes',
        'quoted',
        'hours',

    ];

    public static function scopeSearch($query, $searchTerm)
    {
        return $query->where('id', '=', $searchTerm)
            ->orWhere('repair_customer', 'like', '%' . $searchTerm . '%')
            ->orderBy('date', 'desc');

    }
}