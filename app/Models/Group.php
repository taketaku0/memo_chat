<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory;

    // use SoftDeletes;
    // protected $dates = ['deleted_at'];

    protected $fillable = [
        'group_name',
        'group_description',
        'host',
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function messages()
    {
        return $this->hasMany('App\Models\Message');
    }
}
