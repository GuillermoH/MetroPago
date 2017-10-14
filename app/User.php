<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /*
     * Definicion de relaciones
     */
    public function roles(){
        return $this->belongsToMany('App\Role', 'user_role','user_id','role_id');
    }

    public function userPurchase(){
        return $this->hasMany('App\Purchase', 'user_id');
    }

    public function storePurchase(){
        return $this->hasMany('App\Purchase', 'store_id');
    }

    public function deposit(){
        return $this->hasMany('App\Deposit', 'user_id');
    }

    public function image(){
        return $this->hasOne('App\Image');
    }

    /*
     * Metodos de comprobacion de rol para el Middleware
     */

    public function hasAnyRole($roles){
        if(is_array($roles)){
            foreach ($roles as $role){
                if($this->hasRole($role)){
                    return true;
                }
            }
        }else{
            if($this->hasRole($roles)){
                return true;
            }
        }

        return false;
    }



    public function hasRole($role){
        if($this->roles()->where('name', $role)->first()){
            return true;
        }
        return false;
    }
}
