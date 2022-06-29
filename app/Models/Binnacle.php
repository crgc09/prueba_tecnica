<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Binnacle extends Model
{
    protected $table = 'binnacles';
    protected $fillable = ['action','method','original_url','bitly_url'];
}
