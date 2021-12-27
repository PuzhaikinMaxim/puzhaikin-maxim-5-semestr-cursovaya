<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'rooms_amount',
        'total_price',
        'client_id',
        'cleaner_id',
        'address',
        'order_date_time',
        'phone_number',
        'additional_services'
    ];

}
