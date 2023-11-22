<?php

namespace App\Models\Resources;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class   Person extends Model
{
    use HasFactory;

    protected $table = 'persons';

    protected $fillable = [
        'name',
        'father_last_name',
        'mother_last_name',
        'document_type',
        'document_number',
        'gender',
        'phone',
        'birth_date',
        'birth_country_id',
        'is_foreigner',
        'is_active',
    ];

    protected $dates = [
        'birth_date',
    ];

    public function birthCountry()
    {
        return $this->belongsTo(Country::class, 'birth_country_id');
    }

    static public function registerNew($request)
    {

        $person =  new  Person();
        $person->name = $request->name;
        $person->father_last_name = $request->fatherLastName;
        $person->mother_last_name = $request->motherLastName;
        $person->phone = $request->phone;
        $person->document_number = $request->documentNumber;
        $person->save();
        return $person;
    }

    static public function updatePerson($request)
    {
        $person =  Person::find($request->personId);
        $person->name = $request->name;
        $person->father_last_name = $request->fatherLastName;
        $person->mother_last_name = $request->motherLastName;
        $person->phone = $request->phone;
        $person->document_number = $request->documentNumber;
        $person->save();
        return $person;
    }


    public function registerPhoto($request, $person)
    {
        $person->photo = $request->file('photo')->store('photos');
        $person->save();
        return $person;
    }
}
