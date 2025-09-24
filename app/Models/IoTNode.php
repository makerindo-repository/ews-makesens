<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IoTNode extends Model
{
    use HasFactory;
    protected $table = 'iot_nodes';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
