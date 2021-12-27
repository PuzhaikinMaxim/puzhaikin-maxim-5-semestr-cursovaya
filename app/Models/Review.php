<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'client_id',
        'cleaner_id',
        'rating',
        'review_title',
        'review_text'
    ];

    public function client() {
        return $this->hasOne('App\User','id','client_id');
    }

    public function cleaner() {
        return $this->hasOne('App\User','id','cleaner_id');
    }
}
