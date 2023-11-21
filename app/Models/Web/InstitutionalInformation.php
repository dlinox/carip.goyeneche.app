<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionalInformation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'address',
        'phone',
        'email',
        'about_us',
        'mission',
        'vision',
        'organigram',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'organigramUrl',
    ];


    public function getOrganigramUrlAttribute()
    {
        return asset('storage/' . $this->organigram);
    }

}
