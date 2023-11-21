<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationChart extends Model
{
    use HasFactory;

    protected $fillable = [
        'position',
        'level',
        'worker_id',
        'parent_id',
    ];

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    static public function registerNew($request)
    {

        self::updateOrCreate(
            ['id' =>  $request->positionId],
            [
                'position' => $request->positionName,
                'worker_id' => $request->workerId,
            ]
        );
    }
}
