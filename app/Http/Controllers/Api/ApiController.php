<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Office;
use App\Models\Slider;
use Illuminate\Http\Request;

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

    // public function getFe
}
