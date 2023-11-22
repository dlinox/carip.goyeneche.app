<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerSpecialty extends Model
{
    use HasFactory;

    protected $fillable = [
        'worker_id',
        'specialty_id',
    ];

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    static public function registerNew($request, $worker)
    {
        $workerSpecialty = new WorkerSpecialty();
        $workerSpecialty->worker_id = $worker;
        $workerSpecialty->specialty_id = $request->specialty;
        $workerSpecialty->save();
    }

    static public function updateSpecialty($request)
    {
        $workerSpecialty = WorkerSpecialty::find($request->specialtyId);
        $workerSpecialty->specialty_id = $request->specialty;
        $workerSpecialty->save();
    }   
}
