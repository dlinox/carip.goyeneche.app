<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\OrganizationChart;
use App\Models\Resources\Person;
use App\Models\Resources\PersonPhoto;
use App\Models\Worker;
use App\Models\WorkerSpecialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class WorkerController extends Controller
{

    protected $worker;
    public function __construct()
    {
        $this->worker = new Worker();
    }
    public function index(Request $request)
    {

        $perPage = $request->input('perPage', 10);
        $query = Worker::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('fullname', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());

        $itemsAuthorities = OrganizationChart::with('worker')->get();

        return Inertia::render('admin/workers/index', [
            'items' => $items,
            'itemsAuthorities' => $itemsAuthorities,
            'headers' => $this->worker->headers,
            'filters' => [
                'search' => $request->search,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'fatherLastName' => 'required',
            'motherLastName' => 'required',
            'documentNumber' => 'required',
            'specialty' => 'required',
            'description' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $person = Person::registerNew($request);
            PersonPhoto::registerNew($request, $person->id);
            $worker =  Worker::registerNew($request, $person->id);
            WorkerSpecialty::registerNew($request, $worker->id);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors(['Error al crear el elemento.', $th->getMessage()]);
        }
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            Worker::destroy($id);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors(['Error al eliminar el elemento.', $th->getMessage()]);
        }
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }

    public function authorities(Request $request)
    {
        $request->validate([
            'workerId' => 'required',
            'positionName' => 'required',
            'positionId' => 'nullable',
        ]);

        DB::beginTransaction();

        try {
            OrganizationChart::registerNew($request);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors(['Error al crear el elemento.', $th->getMessage()]);
        }
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function authoritiesDestroy($id)
    {
        DB::beginTransaction();

        try {
            OrganizationChart::destroy($id);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors(['Error al eliminar el elemento.', $th->getMessage()]);
        }
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }
}
