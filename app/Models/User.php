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

    // los campos de nuestros modelos
    protected $fillable = [
        'usr_name',
        'usr_surname',
        'usr_role',
        'usr_estate',
        'usr_email',
        'usr_password',
        'usr_img',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

     // los datos que no devolvera
    protected $hidden = [
        'usr_password',
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

    // relacion de uno a muchos
    public function categories(){
        return $this->hastMany('App\Category');
    }
}
