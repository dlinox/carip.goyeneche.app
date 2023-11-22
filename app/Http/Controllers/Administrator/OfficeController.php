<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OfficeController extends Controller
{
    
    protected $office;
    public function __construct()
    {
        $this->office = new Office();
    }
    public function index(Request $request)
    {

        $perPage = $request->input('perPage', 10);
        $query = Office::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('admin/offices/index', [
            'items' => $items,
            'headers' => $this->office->headers,
            'filters' => [
                'search' => $request->search,
            ],
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
                    'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
               
                $office = Office::find($request->id);
                $office->name = $request->name;
                $office->description = $request->description;
                if ($request->hasFile('img_path')) {
                    $office->img_path = $request->file('img_path')->store('offices', 'public');
                }
                $office->save();
            } else {
                $request->validate([
                    'name' => 'required|string',
                    'description' => 'required|string',
                    'img_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                $office = Office::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'img_path' => $request->file('img_path')->store('offices', 'public'),
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
        $user = Office::find($id);
        $user->is_active = !$user->is_active;
        $user->save();
        return redirect()->back()->with('success', 'Estado cambiado exitosamente.');
    }

    public function destroy($id)
    {
        try {
            Office::find($id)->delete();
            return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['Error al eliminar el elemento.', $th->getMessage()]);
        }
    }


}
