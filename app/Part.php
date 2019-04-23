<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    protected $fillable = [
        'description',
        'cost',
        'price',
        'count',
        'supplier_no',
        'notes',
        'stock_item',
        'supplier_id',
        'group_id',
    ];

    public static function scopeSearch($query, $searchTerm)
    {
        return $query->where('id', '=', $searchTerm)
            ->orWhere('description', 'like', '%' . $searchTerm . '%');

    }

}