<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'ar_title',
        'en_title',
        'ar_subtitle',
        'en_subtitle',
    ];
}
