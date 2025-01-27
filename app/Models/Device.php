<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'location'];

    public function sensors()
    {
        return $this->hasMany(Sensor::class);
    }
}
