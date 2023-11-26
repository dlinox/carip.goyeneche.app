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
        'name',
        'father_last_name',
        'mother_last_name',
        'phone_number',
        'document_type',
        'document_number',
        'role',
        'email',
        'password',
        'is_active',
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
        ['text' => "Nombre", 'value' => "name", 'short' => false, 'order' => 'ASC'],
        ['text' => "Correo", 'value' => "email", 'short' => false, 'order' => 'ASC'],
        ['text' => "Rol", 'value' => "role", 'short' => false, 'order' => 'ASC'],
        ['text' => "Estado", 'value' => "isActive", 'short' => false, 'order' => 'ASC'],
    ];



    static public function registerNew($request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->father_last_name = $request->fatherLastName;
        $user->mother_last_name = $request->motherLastName;
        $user->document_number = $request->documentNumber;
        $user->phone_number = $request->phoneNumber;
        $user->role = $request->role;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->area_id = $request->areaId;
        $user->save();
        return $user;
    }

    static public function updateUser($request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->father_last_name = $request->fatherLastName;
        $user->mother_last_name = $request->motherLastName;
        $user->document_number = $request->documentNumber;
        $user->phone_number = $request->phoneNumber;
        $user->role = $request->role;
        $user->email = $request->email;
        $user->area_id = $request->areaId;
        $user->save();
        return $user;
    }
}
