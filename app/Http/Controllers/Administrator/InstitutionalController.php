<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Web\InstitutionalInformation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InstitutionalController extends Controller
{
    public function index()
    {

        $institutional = InstitutionalInformation::first();

        return Inertia::render('admin/institutional/index', [
            'institutional' => $institutional,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'aboutUs' => 'required',
            'mission' => 'required',
            'vision' => 'required',
            'organigram' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4048',
        ]);


        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'about_us' => $request->aboutUs,
            'mission' => $request->mission,
            'vision' => $request->vision,
        ];

        if ($request->file('organigram')) {
            $data['organigram'] = $request->file('organigram')->store('organigram', 'public');
        }

        InstitutionalInformation::updateOrCreate(
            ['id' =>  $request->id],
            $data
        );
        return redirect()->back()->with('success', 'Información institucional actualizada');
    }
}
