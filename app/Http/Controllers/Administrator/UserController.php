<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
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
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->select(
            'users.id',
            'users.name',
            'users.email',
            'users.role',
            'users.is_active as isActive' ,
            'users.phone_number as phoneNumber',
            'users.document_number as documentNumber',
            'users.father_last_name as fatherLastName',
            'users.mother_last_name as motherLastName'
        )
            ->paginate($perPage)->appends($request->query());

        return Inertia::render('admin/users/index', [
            'items' => $items,
            'headers' => $this->user->headers,
            'filters' => [
                'search' => $request->search,
            ],
        ]);
    }

    public function store(UserRequest $request)
    {
        
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

    public function update(UserRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            User::updateUser($request, $id);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors(['Error al crear el elemento.', $th->getMessage()]);
        }
        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
        }
    //parangaricutirimicuaro
    public function changeState($id)
    {
        $user = User::find($id);
        $user->is_active = !$user->is_active;
        $user->save();
        return redirect()->back()->with('success', 'Estado cambiado exitosamente.');
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }
}
