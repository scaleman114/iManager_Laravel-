<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'cust_name',
        'address',
        'main_phone',
        'main_email',
        'vatno',
      ];

      public static function scopeSearch($query, $searchTerm)
      {
          return $query->where('cust_name', 'like', '%' .$searchTerm. '%')
                       ->orWhere('address', 'like', '%' .$searchTerm. '%');
                       
      } 
}
