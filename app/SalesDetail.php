<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesDetail extends Model
{
    public function sale() {
        return $this->belongsTo(Sale::class);
    }
}
