<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SpecialtyController extends Controller
{
    protected $specialty;
    public function __construct()
    {
        $this->specialty = new Specialty();
    }
    public function index(Request $request)
    {

        $perPage = $request->input('perPage', 10);
        $query = Specialty::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('admin/specialties/index', [
            'items' => $items,
            'headers' => $this->specialty->headers,
            'filters' => [
                'search' => $request->search,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $specialty = new Specialty();
        $specialty->name = $request->name;
        $specialty->description = $request->description;
        $specialty->save();

        return redirect()->route('a.specialties.index')->with('success', 'Especialidad creada correctamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $specialty = Specialty::find($id);
        $specialty->name = $request->name;
        $specialty->description = $request->description;
        $specialty->save();

        return redirect()->route('a.specialties.index')->with('success', 'Especialidad actualizada correctamente');
    }

}
