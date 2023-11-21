<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'fullname',
        'role',
        'email',
        'password',
        'is_active',
        'person_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean'
    ];

    public $headers =  [
        ['text' => "ID", 'value' => "id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "fullname", 'short' => false, 'order' => 'ASC'],
        ['text' => "Correo", 'value' => "email", 'short' => false, 'order' => 'ASC'],
        ['text' => "Rol", 'value' => "role", 'short' => false, 'order' => 'ASC'],
        ['text' => "Estado", 'value' => "is_active", 'short' => false, 'order' => 'ASC'],
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    static public function registerNew($request, $person)
    {
        $user = new User();
        $user->fullname = $request->name . ' ' . $request->fatherLastName . ' ' . $request->motherLastName;
        $user->role = $request->role;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->person_id = $person;
        $user->save();
        return $user;
    }

    static public function updateUser($request, $person)
    {
        $user = User::find($request->id);
        $user->fullname = $request->name . ' ' . $request->fatherLastName . ' ' . $request->motherLastName;
        $user->role = $request->role;
        $user->email = $request->email;
        $user->person_id = $person;
        $user->save();
        return $user;
    }
}
