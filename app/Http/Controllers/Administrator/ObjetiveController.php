<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\InstitutionalObjetive;
use App\Models\Objetive;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ObjetiveController extends Controller
{

    protected $objetive;
    public function __construct()
    {
        $this->objetive = new Objetive();
    }

    public function index(Request $request)
    {

        $perPage = $request->input('perPage', 10);
        $query = Objetive::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());


        // return response()->json([
        //     'items' => $items,
        //     'headers' => $this->objetive->headers,
        //     'filters' => [
        //         'search' => $request->search,
        //     ],
        // ]);

        return Inertia::render('admin/objetives/index', [
            'items' => $items,
            'headers' => $this->objetive->headers,
            'filters' => [
                'search' => $request->search,
            ],
        ]);
    }


    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string',
            ],
            [
                'name.required' => 'El nombre es requerido.',
            ]
        );

        InstitutionalObjetive::create($request->all());

        return redirect()->back()
            ->with('message', 'Objetivo creado exitosamente.');
    }


    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'name' => 'required|string',
            ],
            [
                'name.required' => 'El nombre es requerido.',
            ]
        );

        InstitutionalObjetive::find($id)->update($request->all());

        return redirect()->back()
            ->with('message', 'Objetivo actualizado exitosamente.');
    }

    public function changeState($id)
    {
        $objetive = Objetive::find($id);
        $objetive->is_active = !$objetive->is_active;
        $objetive->save();

        return redirect()->back()
            ->with('message', 'Estado del objetivo actualizado exitosamente.');
    }
    public function destroy(string $id)
    {
        InstitutionalObjetive::find($id)->delete();

        return redirect()->back()
            ->with('message', 'Objetivo eliminado exitosamente.');

    }
}
