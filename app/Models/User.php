<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role() {
        return $this->hasOne('App\Role','role_id','id');
    }

    public function client_review() {
        return $this->hasMany('App\Review','id','client_id');
    }

    public function cleaner_review() {
        return $this->hasMany('App\Review','id','cleaner_id');
    }

    public function client_order() {
        return $this->hasMany('App\Order','id','client_id');
    }

    public function cleaner_order() {
        return $this->hasMany('App\Order','id','cleaner_id');
    }
}
