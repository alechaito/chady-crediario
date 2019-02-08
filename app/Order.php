<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    protected $table = 'orders';

    protected $fillable = [
        'profile_id',
        'items',
        'total',
    ];
}
