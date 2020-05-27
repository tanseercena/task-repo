<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    public function user() {
      return $this->belongsTo(User::class);
    }

    public function service() {
      return $this->belongsTo(Service::class);
    }
}
