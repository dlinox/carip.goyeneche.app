<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\SupportingService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupportingServicesController extends Controller
{

    protected $supportingService;
    public function __construct()
    {
        $this->supportingService = new SupportingService();
    }
    public function index(Request $request)
    {

        $perPage = $request->input('perPage', 10);
        $query = SupportingService::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('admin/supportingServices/index', [
            'items' => $items,
            'headers' => $this->supportingService->headers,
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

        SupportingService::create($request->all());

        return redirect()->back()
            ->with('message', 'Servicio de apoyo creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string',
            ],
            [
                'name.required' => 'El nombre es requerido.',
            ]
        );

        SupportingService::find($id)->update($request->all());

        return redirect()->back()
            ->with('message', 'Servicio de apoyo actualizado exitosamente.');
    }

    public function changeState($id)
    {
        $user = SupportingService::find($id);
        $user->is_active = !$user->is_active;
        $user->save();
        return redirect()->back()->with('success', 'Estado cambiado exitosamente.');
    }

    public function destroy($id)
    {
        try {
            SupportingService::find($id)->delete();
            return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['Error al eliminar el elemento.', $th->getMessage()]);
        }
    }
}
