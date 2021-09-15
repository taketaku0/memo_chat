<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start',
        'end',
        'user_id',
    ];
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
