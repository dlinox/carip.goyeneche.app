<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcements extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date_published',
        'date_expired',
        'document',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'documentPath',
    ];

    public function getDocumentPathAttribute()
    {
        return asset('storage/' . $this->document);
    }

    public $headers =  [
        ['text' => "ID", 'value' => "id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "title", 'short' => false, 'order' => 'ASC'],
        ['text' => "Descripción", 'value' => "description", 'short' => false, 'order' => 'ASC'],
        ['text' => "Estado", 'value' => "is_active", 'short' => false, 'order' => 'ASC'],
    ];

    

}
