<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicationDocument extends Model
{
    use HasFactory;

    
    protected $fillable = ["publication_id", "name", "file", "date_published", "is_active"];

    protected $casts = [
        "is_active" => "boolean"
    ];

    protected $appends = [
        "filePath"
    ];

    protected $hidden = [
        "file",
        "created_at",
        "updated_at"
    ];

    public $headers =  [
        ['text' => "ID", 'value' => "id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "name", 'short' => false, 'order' => 'ASC'],
        ['text' => "Archivo", 'value' => "file", 'short' => false, 'order' => 'ASC'],
        ['text' => "Fecha de publicación", 'value' => "date_published", 'short' => false, 'order' => 'ASC'],
        ['text' => "Activo", 'value' => "is_active", 'short' => false, 'order' => 'ASC'],
    ];

    public function getFilePathAttribute()
    {
        return asset("storage/" . $this->file);
    }
}
