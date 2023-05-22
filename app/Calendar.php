<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $fillable = ['datefield'];

    public $timestamps = false;
}
