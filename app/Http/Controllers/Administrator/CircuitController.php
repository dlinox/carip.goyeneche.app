<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Circuit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CircuitController extends Controller
{


    protected $circuit;
    public function __construct()
    {
        $this->circuit = new Circuit();
    }
    
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = Circuit::query();
        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('guide_name', 'like', '%' . $searchTerm . '%');
        }
        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('admin/circuit/index', [
            'items' => $items,
            'headers' => $this->circuit->headers,
            'filters' => [
                'search' => $request->search,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'guideName' => 'required',
            'guideFile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'resolutionName' => 'nullable',
            'resolutionFile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            
        ]);

        //$request->file('organigram')->store('organigram', 'public');
        $circuit = Circuit::create([
            'guide_name' => $request->guideName,
            'guide_file' => $request->file('guideFile')->store('circuit/guides', 'public'),
            'resolution_name' => $request->resolutionName,
            'resolution_file' => $request->hasFile('resolutionFile') ? $request->file('resolutionFile')->store('circuit/resolutions', 'public') : null,
        ]);

        return redirect()->back()->with('success', 'Circuit created.');
    }

    public function changeState($id)
    {
        $circuit = Circuit::find($id);
        $circuit->is_active = !$circuit->is_active;
        $circuit->save();

        return redirect()->back()->with('success', 'Circuit updated.');
    }
}
