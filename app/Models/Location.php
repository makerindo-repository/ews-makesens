<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function node()
    {
        return $this->hasOne(IoTNode::class);
    }

    public function user()
    {
        return $this->hasMany(User::class, 'location_id');
    }
}
