<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'img_path',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute()
    {
        return $this->img_path ? asset('storage/' . $this->img_path) : null;
    }

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
