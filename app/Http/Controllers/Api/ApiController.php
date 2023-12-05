<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getSliders(){

        $sliders = Slider::select('title','subtitle', 'image', 'link' )->where('is_active', true)->get();
        return response()->json($sliders ? $sliders : []);

    }

    // public function getFe
}
