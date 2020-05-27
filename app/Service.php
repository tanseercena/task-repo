<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function users() {
      return $this->belongsToMany(User::class);
    }

    public function appointments() {
      return $this->hasMany(Appointment::class);
    }
}
