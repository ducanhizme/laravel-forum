<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Votable extends Model
{
    use HasFactory;
    protected $table = 'votable';

    protected $fillable = [
        'votable_id',
        'votable_type',
        'user_id',
        'type'
    ];

    public function votable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }
}
