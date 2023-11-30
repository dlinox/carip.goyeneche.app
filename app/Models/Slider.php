<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = ["title", "subtitle", "image", "link", "is_active"];

    protected $casts = [
        "is_active" => "boolean"
    ];

    protected $appends = [
        "image_path"
    ];

    public $headers =  [
        ['text' => "ID", 'value' => "id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Título", 'value' => "title", 'short' => false, 'order' => 'ASC'],
        ['text' => "Subtítulo", 'value' => "subtitle", 'short' => false, 'order' => 'ASC'],
        ['text' => "Imagen", 'value' => "image", 'short' => false, 'order' => 'ASC'],
        ['text' => "Link", 'value' => "link", 'short' => false, 'order' => 'ASC'],
        ['text' => "Activo", 'value' => "is_active", 'short' => false, 'order' => 'ASC'],
    ];

    public function getImagePathAttribute()
    {
        return asset("storage/" . $this->image);
    }

    public function scopeActive($query)
    {
        return $query->where("is_active", true);
    }

    public function scopeInactive($query)
    {
        return $query->where("is_active", false);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy("created_at", "desc");
    }


}
