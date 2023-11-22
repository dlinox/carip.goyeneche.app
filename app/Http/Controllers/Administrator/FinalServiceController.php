<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\FinalService;
use App\Models\Specialty;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class FinalServiceController extends Controller
{

    protected $finalService;
    public function __construct()
    {
        $this->finalService = new FinalService();
    }

    public function index(Request $request)
    {

        $perPage = $request->input('perPage', 10);
        $query = FinalService::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('admin/finalService/index', [
            'items' => $items,
            'headers' => $this->finalService->headers,
            'filters' => [
                'search' => $request->search,
            ],
            'specialties' => Specialty::all(),
            'doctors' => Worker::all(),
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            if ($request->id) {

                $request->validate([
                    'name' => 'required|string',
                    'description' => 'required|string',
                    'specialty_id' => 'required|exists:specialties,id',
                    'worker_id' => 'required|exists:workers,id',
                    'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

                ]);

                $office = FinalService::find($request->id);
                $office->name = $request->name;
                $office->specialty_id = $request->specialty_id;
                $office->worker_id = $request->worker_id;
                $office->description = $request->description;
                if ($request->hasFile('img_path')) {
                    $office->img_path = $request->file('img_path')->store('finalServices', 'public');
                }
                $office->save();
            } else {
                $request->validate([
                    'name' => 'required|string',
                    'description' => 'required|string',
                    'specialty_id' => 'required|exists:specialties,id',
                    'worker_id' => 'required|exists:workers,id',
                    'img_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                $office = FinalService::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'specialty_id' => $request->specialty_id,
                    'worker_id' => $request->worker_id,
                    'img_path' => $request->file('img_path')->store('finalServices', 'public'),
                ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors(['Error al crear el elemento.', $th->getMessage()]);
        }
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }


    public function changeState($id)
    {
        $user = FinalService::find($id);
        $user->is_active = !$user->is_active;
        $user->save();
        return redirect()->back()->with('success', 'Estado cambiado exitosamente.');
    }
}
