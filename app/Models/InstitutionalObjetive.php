<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionalObjetive extends Model
{
    use HasFactory;

    // protected $table = 'institutional_objectives';
    protected $fillable = [
        'name',
        'description',
        'is_active'   
    ];

    protected $casts = [
        'is_active'  => 'boolean'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public $headers =  [
        ['text' => "ID", 'value' => "id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "name", 'short' => false, 'order' => 'ASC'],
        ['text' => "Estado", 'value' => "is_active", 'short' => false, 'order' => 'ASC'],
    ];


}
