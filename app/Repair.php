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
        'email',

    ];

    public static function scopeSearch($query, $searchTerm)
    {
        if ($searchTerm != '') {
            $q = $query->where('id', '=', $searchTerm)
                ->orWhere('repair_customer', 'like', '%' . $searchTerm . '%')
                ->orderBy('date', 'desc')
                ->paginate(5);
        } else {
            $q = $query->orderBy('date', 'desc')
                ->paginate(5);
            //dd($q);
        }
        return $q;

    }
}