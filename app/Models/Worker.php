<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'description',
        'person_id',
        'code',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];


    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public $headers =  [
        ['text' => "ID", 'value' => "id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "fullname", 'short' => false, 'order' => 'ASC'],
        ['text' => "Descripción", 'value' => "description", 'short' => false, 'order' => 'ASC'],
        ['text' => "Foto", 'value' => "photo", 'short' => false, 'order' => 'ASC'],
        ['text' => "Estado", 'value' => "is_active", 'short' => false, 'order' => 'ASC'],
    ];

    static public function registerNew($request, $person)
    {
        $user = new Worker();
        $user->fullname = $request->name . ' ' . $request->fatherLastName . ' ' . $request->motherLastName;
        $user->description = $request->description;
        $user->code = $request->code;
        $user->person_id = $person;
        $user->save();
        return $user;
    }

    static public function updateWorker($request, $id)
    {
        $user = Worker::find($id);
        $user->fullname = $request->name . ' ' . $request->fatherLastName . ' ' . $request->motherLastName;
        $user->description = $request->description;
        $user->code = $request->code;
        $user->save();
        return $user;
    }
}
