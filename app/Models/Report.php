<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [ 'user_id', 'type', 'description', 'location', 'status', 'latitude', 'longitude'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getLocationAttribute()
    {
        return [
            'lat' => $this->latitude,
            'lng' => $this->longitude,
        ];
    }

    public function setLocationAttribute($value)
    {
        $this->attributes['latitude'] = $value['lat'];
        $this->attributes['longitude'] = $value['lng'];
    }
}
