<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'img_path',
        'description',
        'author',
        'is_active',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public $headers =  [
        ['text' => "ID", 'value' => "id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "name", 'short' => false, 'order' => 'ASC'],
        ['text' => "Documentos", 'value' => "documents", 'short' => false, 'order' => 'ASC'],

        ['text' => "Estado", 'value' => "is_active", 'short' => false, 'order' => 'ASC'],
    ];

    protected $with = [
        'documents',
    ];

    public function documents()
    {
        return $this->hasMany(PublicationDocument::class, 'publication_id');
    }

}
