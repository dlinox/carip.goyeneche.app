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
            'guideFile' => 'required|file|mimes:pdf',
            'resolutionName' => 'required',
            'resolutionFile' => 'required|file|mimes:pdf',
        ]);

        //$request->file('organigram')->store('organigram', 'public');
        $circuit = Circuit::create([
            'guide_name' => $request->guideName,
            'guide_file' => $request->file('guideFile')->store('circuit/guides', 'public'),
            'resolution_name' => $request->resolutionName,
            'resolution_file' => $request->file('resolutionFile')->store('circuit/resolutions', 'public'),
        ]);

        return redirect()->back()->with('success', 'Circuit created.');
    }
}
