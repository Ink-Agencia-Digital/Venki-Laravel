<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class quiz extends Model
{
    protected $table='quiz'; 
    protected $fillable = [
        "id_user",
        "id_resource",
        "pregunta",
        "respuesta"
    ];

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
