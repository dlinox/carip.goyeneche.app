<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdministratorController extends Controller
{

    
    public function index()
    {
        return Inertia::render('admin/index');
    }
}
