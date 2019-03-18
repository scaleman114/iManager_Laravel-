<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZohoContact extends Model
{
    //

    public static function scopeSearch($query, $searchTerm)
    {
        //dd($query);
        return $query->where('customer_name', 'like', '%' . $searchTerm . '%')
            ->orWhere('first_name', 'like', '%' . $searchTerm . '%');

    }
}