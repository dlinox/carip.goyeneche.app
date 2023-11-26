<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\IntermediateService;
use App\Models\SupportingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class IntermediateServiceController extends Controller
{



    protected $intermediateService;
    public function __construct()
    {
        $this->intermediateService = new IntermediateService();
    }

    public function index(Request $request)
    {

        $perPage = $request->input('perPage', 10);
        $query = IntermediateService::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('admin/intermediateService/index', [
            'items' => $items,
            'headers' => $this->intermediateService->headers,
            'filters' => [
                'search' => $request->search,
            ],
            'supportingServices' => SupportingService::all(),

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
                    'supporting_service_id' => 'required|exists:supporting_services,id',
                    'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

                ]);

                $office = IntermediateService::find($request->id);
                $office->name = $request->name;
                $office->supporting_service_id = $request->supporting_service_id;

                $office->description = $request->description;
                if ($request->hasFile('img_path')) {
                    $office->img_path = $request->file('img_path')->store('intermediateService', 'public');
                }
                $office->save();
            } else {
                $request->validate([
                    'name' => 'required|string',
                    'description' => 'required|string',
                    'supporting_service_id' => 'required|exists:specialties,id',
                    'img_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                $office = IntermediateService::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'supporting_service_id' => $request->supporting_service_id,
                    'img_path' => $request->file('img_path')->store('intermediateService', 'public'),
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
        $user = IntermediateService::find($id);
        $user->is_active = !$user->is_active;
        $user->save();
        return redirect()->back()->with('success', 'Estado cambiado exitosamente.');
    }

    public function destroy($id)
    {
        $user = IntermediateService::find($id);
        $user->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }
}
