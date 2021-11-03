<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes;

    protected $fillable = ["name"];


    /** Relationships */

    public function questions()
    {
        return $this->hasManyThrough(Question::class, Survey::class);
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }

    public function descriptions()
    {
        return $this->hasMany(Description::class);
    }

    public function notifications()
    {
        return $this->hasMany(notification::class,'id_profile');
    }
}
