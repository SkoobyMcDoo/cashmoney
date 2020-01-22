<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $guarded = [];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
