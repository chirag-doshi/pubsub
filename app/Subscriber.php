<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Subscriber extends Model
{
    protected $fillable = ['topic', 'url'];

}
