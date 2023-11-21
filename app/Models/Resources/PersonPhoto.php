<?php

namespace App\Models\Resources;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'path',
        'filename',
        'mime_type',
        'extension',
        'size',
        'is_avatar',
        'is_main',
        'is_active',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    protected $casts = [
        'is_avatar' => 'boolean',
        'is_main' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'url',
    ];

    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }

    static public function registerNew($request, $person)
    {
        $photo = new PersonPhoto();
        $photo->person_id = $person;
        $photo->path = $request->file('photo')->store('photos', 'public');
        $photo->filename = $request->file('photo')->getClientOriginalName();
        $photo->mime_type = $request->file('photo')->getMimeType();
        $photo->extension = $request->file('photo')->getClientOriginalExtension();
        $photo->size = $request->file('photo')->getSize();
        $photo->is_avatar = 1;
        $photo->save();
        return $photo;
    }
}
