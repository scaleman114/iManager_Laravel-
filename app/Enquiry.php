<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $fillable = [
        'enq_customer',
        'enq_description',
        'enq_completed',
        'enq_diarydate',
        'user_id',
        'enq_email',
        'enq_phone',
    ];

    public static function scopeSearch($query, $searchTerm)
    {
        return $query->where('enq_customer', 'like', '%' . $searchTerm . '%')
            ->orWhere('enq_description', 'like', '%' . $searchTerm . '%');

    }

    public static function scopeIsCleared($query, $isCleared)
    {
        return $query->where('enq_completed', '=', $isCleared);
    }

    public static function scopeDiary($query, $dateRange)
    {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        switch ($dateRange) {
            case "week";
                return $query
                    ->whereBetween('enq_diarydate', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->where('enq_completed', false)
                    ->orderby('enq_diarydate');
                break;

            case "month":
                return $query
                    ->whereBetween('enq_diarydate', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                    ->where('enq_completed', false)
                    ->orderby('enq_diarydate');
                break;
        }
        /*if ($dateRange == "week")
    return $query
    ->whereBetween('enq_diarydate', [Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()]);*/

    }

}