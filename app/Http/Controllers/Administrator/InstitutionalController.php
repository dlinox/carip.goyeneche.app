<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\InstitutionalObjetive;
use App\Models\Web\InstitutionalInformation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InstitutionalController extends Controller
{
    public function index()
    {

        $institutional = InstitutionalInformation::first();

        $objetives = InstitutionalObjetive::all();

        return Inertia::render('admin/institutional/index', [
            'institutional' => $institutional,
            'objetives' => $objetives,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'description' => 'required',
                'address' => 'required',
                'phone' => 'required',
                'email' => 'required|email',
                'aboutUs' => 'required',
                'mission' => 'required',
                'vision' => 'required',
                'organigram' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4048',
            ],
            [
                'name.required' => 'El nombre es requerido',
                'description.required' => 'La descripción es requerida',
                'address.required' => 'La dirección es requerida',
                'phone.required' => 'El teléfono es requerido',
                'email.required' => 'El correo electrónico es requerido',
                'email.email' => 'El correo electrónico no es válido',
                'aboutUs.required' => 'La información de la empresa es requerida',
                'mission.required' => 'La misión es requerida',
                'vision.required' => 'La visión es requerida',
                'organigram.image' => 'El archivo debe ser una imagen',
                'organigram.mimes' => 'El archivo debe ser una imagen',
                'organigram.max' => 'El archivo no debe pesar más de 4MB',
            ]
        );


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
