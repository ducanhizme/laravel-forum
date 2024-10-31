<?php

namespace App\Trait;

trait Votable
{
    public function vote(){
        return $this->morphMany('App\Models\Votable', 'votable');
    }
}
