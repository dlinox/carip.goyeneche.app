<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AreaController extends Controller
{
    protected $area;
    public function __construct()
    {
        $this->area = new Area();
    }
    public function index(Request $request)
    {

        $perPage = $request->input('perPage', 10);
        $query = Area::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('admin/areas/index', [
            'items' => $items,
            'headers' => $this->area->headers,
            'filters' => [
                'search' => $request->search,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $specialty = new Area();
        $specialty->name = $request->name;
        $specialty->save();

        return redirect()->back()->with('success', 'Especialidad creada correctamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $specialty = Area::find($id);
        $specialty->name = $request->name;
        $specialty->save();

        return redirect()->back()->with('success', 'Especialidad actualizada correctamente');
    }

    public function destroy($id)
    {
        $specialty = Area::find($id);
        $specialty->delete();

        return redirect()->back()->with('success', 'Especialidad eliminada correctamente');
    }
}
