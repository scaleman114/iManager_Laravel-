<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name',

    ];

    public static function getGroupName($id)
    {
        //Get the contact from the local database
        $group = Group::where('group_id', '=', ($id))->first();
        //dd($group);
        if ($group == null) {
            $groupname = '';
        } else {
            $groupname = $group->name;
        }

        return $groupname;
    }
}