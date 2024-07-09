<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'city',
        'country',
        'postal_code',
        'image_path',
        'description',
    ];
    
}
