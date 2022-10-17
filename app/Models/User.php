<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Validator;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'username', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    /**
     * The attributes is validated.
     *
     * @author Cristian Machado
     * @var array<object, object>
     */
    public function isValid($data) {
        $rules = [
            'name' => 'required',
            'username' => 'required|min:4|max:25|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'min:6|required|confirmed'
        ];

        if ($this->id) {
            $rules['username'] = 'required|min:4|max:25|unique:users,username,' . $this->id;
            $rules['email'] = 'required|email|unique:users,email,' . $this->id;
            $rules['password'] = '';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors()->toArray();
        return false;
    }
}
