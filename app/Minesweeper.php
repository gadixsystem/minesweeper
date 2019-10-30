<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Minesweeper extends Model
{
    protected $fillable = [
        'grid', 'userGrid','rows','columns','mines','gameover','user_id','time'
    ];

    protected $casts = ['grid' => 'array','userGrid'=>'array'];

}
