<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorRequest;
use App\Models\OrganizationChart;
use App\Models\Resources\Person;
use App\Models\Resources\PersonPhoto;
use App\Models\Specialty;
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
        $items = $query
            ->select(
                'workers.id',
                'workers.fullname',
                'workers.description',
                'workers.code',
                'workers.is_active',

                'persons.id as personId',
                'persons.document_number as documentNumber',
                'persons.name',
                'persons.phone',
                'persons.father_last_name as fatherLastName',
                'persons.mother_last_name as motherLastName',

                'person_photos.id as photoId',
                'person_photos.path as photo',


                'worker_specialties.id as specialtyId',
                'worker_specialties.specialty_id as specialty',

            )
            ->join('persons', 'persons.id', '=', 'workers.person_id')
            ->join('person_photos', 'person_photos.person_id', '=', 'persons.id')
            ->join('worker_specialties', 'worker_specialties.worker_id', '=', 'workers.id')
            ->paginate($perPage)->appends($request->query());

        $itemsAuthorities = OrganizationChart::with('worker')->get();
        $specialties = Specialty::select('id', 'name')->get();

        return Inertia::render('admin/workers/index', [
            'items' => $items,
            'itemsAuthorities' => $itemsAuthorities,
            'headers' => $this->worker->headers,
            'specialties' => $specialties,
            'filters' => [
                'search' => $request->search,
            ],
        ]);
    }

    public function store(DoctorRequest $request)
    {
        DB::beginTransaction();
        try {

            if ($request->id) {
                Worker::updateWorker($request, $request->id);
                Person::updatePerson($request);
                
                if ($request->hasFile('photo')) {
                    PersonPhoto::updatePhoto($request);
                }
                WorkerSpecialty::updateSpecialty($request);
            } else {
                $person = Person::registerNew($request);
                PersonPhoto::registerNew($request, $person->id);
                $worker =  Worker::registerNew($request, $person->id);
                WorkerSpecialty::registerNew($request, $worker->id);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors(['Error al crear el elemento.', $th->getMessage()]);
        }
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(DoctorRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            Worker::updateWorker($request, $id);
            Person::updatePerson($request);
            PersonPhoto::updatePhoto($request);
            WorkerSpecialty::updateSpecialty($request);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors(['Error al actualizar el elemento.', $th->getMessage()]);
        }
        return redirect()->back()->with('success', 'Elemento actualizado exitosamente.');
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

    public function changeState($id)
    {
        $user = Worker::find($id);
        $user->is_active = !$user->is_active;
        $user->save();
        return redirect()->back()->with('success', 'Estado cambiado exitosamente.');
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
