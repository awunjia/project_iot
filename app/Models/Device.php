<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'description', 'location'];

    public function sensors()
    {
        return $this->hasMany(Sensor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
