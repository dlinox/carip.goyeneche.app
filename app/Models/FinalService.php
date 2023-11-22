<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalService extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'img_path',
        'description',
        'specialty_id',
        'worker_id',
        'is_active',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public $headers =  [
        ['text' => "ID", 'value' => "id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "name", 'short' => false, 'order' => 'ASC'],
        // ['text' => "Especialidad", 'value' => "specialty_id", 'short' => false, 'order' => 'ASC'],
        // ['text' => "Trabajador", 'value' => "worker_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Estado", 'value' => "is_active", 'short' => false, 'order' => 'ASC'],
    ];



    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
}
