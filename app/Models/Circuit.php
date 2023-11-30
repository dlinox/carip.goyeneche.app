<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Circuit extends Model
{
    use HasFactory;

    protected $fillable = [
        'guide_name',
        'guide_file',
        'resolution_name',
        'resolution_file',
        'date_published',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public $headers =  [
        ['text' => "ID", 'value' => "id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Doc. Guia", 'value' => "guideName", 'short' => false, 'order' => 'ASC'],
        ['text' => "Resolución", 'value' => "resolutionName", 'short' => false, 'order' => 'ASC'],
        ['text' => "Fecha de publicación", 'value' => "datePublished", 'short' => false, 'order' => 'ASC'],
        ['text' => "Activo", 'value' => "isActive", 'short' => false, 'order' => 'ASC'],

    ];

    protected $appends = [
        'guideFilePath',
        'resolutionFilePath',
    ];

    public function getGuideFilePathAttribute()
    {
        return asset('storage/' . $this->guide_file);
    }
    public function getResolutionFilePathAttribute()
    {
        return asset('storage/' . $this->resolution_file);
    }
}
