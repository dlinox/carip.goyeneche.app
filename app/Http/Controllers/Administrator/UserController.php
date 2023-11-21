<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Resources\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class UserController extends Controller
{


    protected $user;
    public function __construct()
    {
        $this->user = new User();
    }
    public function index(Request $request)
    {

        $perPage = $request->input('perPage', 10);
        $query = User::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('fullname', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->select(
            'users.*',
            'persons.document_number as documentNumber',
            'persons.name',
            'persons.phone',
            'persons.father_last_name as fatherLastName',
            'persons.mother_last_name as motherLastName'
        )
            ->join('persons', 'persons.id', '=', 'users.person_id')
            ->paginate($perPage)->appends($request->query());

        return Inertia::render('admin/users/index', [
            'items' => $items,
            'headers' => $this->user->headers,
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
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $person = Person::registerNew($request);
            User::registerNew($request, $person->id);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors(['Error al crear el elemento.', $th->getMessage()]);
        }
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'fatherLastName' => 'required',
            'motherLastName' => 'required',
            'documentNumber' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'role' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $person = Person::updatePerson($request);
            User::updateUser($request, $person->id);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors(['Error al crear el elemento.', $th->getMessage()]);
        }
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }
}
