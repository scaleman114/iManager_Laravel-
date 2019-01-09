<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'contact_name',
        'job_title',
        'phone',
        'ext',
        'mobile',
        'email',
      ];

      public function customer()
      {
          return $this->belongsTo('App\Customer');
      }
}