<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    protected $fillable = [
        'sql',
        'description',
        'connection_id',
    ];

    public function connection()
    {
        return $this->belongsTo(Connection::class);
    }
}
