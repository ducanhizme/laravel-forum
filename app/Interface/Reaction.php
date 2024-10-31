<?php

namespace App\Interface;

interface Reaction
{
    public function vote();
    public function comment($object,$data);
}
