<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IntermediateServiceController extends Controller
{
    public function index()
    {
        return Inertia::render('admin/intermediateService/index');
    }
}
