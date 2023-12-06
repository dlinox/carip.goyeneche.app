<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Office;
use App\Models\Slider;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function getSliders()
    {

        $sliders = Slider::select('title', 'subtitle', 'image', 'link')->where('is_active', true)->get();
        return response()->json($sliders ? $sliders : []);
    }

    public function getNews()
    {

        $news = News::select(
            'news.title',
            'news.description',
            'news.image',
            'news.date_publish',
            'news.author',
            'users.name as author_name',
            'users.father_last_name as author_father_last_name',
            'users.mother_last_name as author_mother_last_name',
            'areas.name as area_name'
        )
            ->join('users', 'users.id', '=', 'news.author')
            ->leftjoin('areas', 'areas.id', '=', 'users.area_id')

            ->where('news.is_active', true)->get();
        return response()->json($news ? $news : []);
    }

    public function getOffices(){
        $offices = Office::all();
        return response()->json($offices ? $offices : []);
    }
/**
 *class PersonPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'path',
        'filename',
        'mime_type',
        'extension',
        'size',
        'is_avatar',
        'is_main',
        'is_active',
    ];
 * 
 */
//base url laravel 

  

    public function getDoctors(){

        $base_url = url('/');

        $doctors = Worker::select(
            'workers.id',
            'workers.fullname',
            'workers.is_active',
            'specialties.name as specialty_name',
            DB::raw("CONCAT('$base_url','/storage/',person_photos.path) as photo")
            )
        ->where('workers.is_active', true)
        ->join('worker_specialties', 'worker_specialties.worker_id', '=', 'workers.id')
        ->join('specialties', 'specialties.id', '=', 'worker_specialties.specialty_id')
        ->join('person_photos', 'person_photos.person_id', '=', 'workers.person_id')
        ->get();

        return response()->json($doctors ? $doctors : []);
    }


    // public function getFe
}
