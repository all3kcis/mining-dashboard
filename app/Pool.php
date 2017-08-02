<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pool extends Model
{

	protected $fillable = [
        'name', 'type',
    ];


    public function miners(){
        return $this->hasMany('App\Miner');
    }
}
