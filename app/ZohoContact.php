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
    public static function scopeCustomerSearch($query, $searchTerm)
    {
        

            if ($searchTerm != '') {
                $q = $query->where('contact_type','=','customer')
                ->where('customer_name', 'like', '%' . $searchTerm . '%')
                ->orWhere('first_name', 'like', '%' . $searchTerm . '%');
            } else {
                $q = $query->where('contact_type','=','customer');
                //dd($q);
            }
            return $q;
    

    }

    public static function scopeVendorSearch($query, $searchTerm)
    {
        

            if ($searchTerm != '') {
                $q = $query->where('contact_type','=','vendor')
                ->where('customer_name', 'like', '%' . $searchTerm . '%')
                ->orWhere('first_name', 'like', '%' . $searchTerm . '%');
            } else {
                $q = $query->where('contact_type','=','vendor');
                //dd($q);
            }
            return $q;
    

    }
}