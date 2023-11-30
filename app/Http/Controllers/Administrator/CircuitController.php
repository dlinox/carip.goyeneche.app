<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Circuit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $items = $query
        ->select(
            'circuits.id',
            'circuits.date_published as datePublished',
            'circuits.guide_name as guideName',
            'circuits.guide_file as guideFile',
            'circuits.resolution_name as resolutionName',
            'circuits.resolution_file as resolutionFile',
            'circuits.is_active as isActive')
        ->paginate($perPage)->appends($request->query());

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

        if($request->id){
            $request->validate([
                'guideName' => 'required',
                'guideFile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'resolutionName' => 'required',
                'resolutionFile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'datePublished' => 'required|date',
            ]);
            $circuit = Circuit::find($request->id);
            $circuit->guide_name = $request->guideName;
            $circuit->resolution_name = $request->resolutionName;
            $circuit->date_published = $request->datePublished;
            if($request->hasFile('guideFile')){
                Storage::disk('public')->delete($circuit->guide_file);
                $circuit->guide_file = $request->file('guideFile')->store('circuit/guides', 'public');
            }
            if($request->hasFile('resolutionFile')){
                Storage::disk('public')->delete($circuit->resolution_file);
                $circuit->resolution_file = $request->file('resolutionFile')->store('circuit/resolutions', 'public');
            }
            $circuit->save();
            return redirect()->back()->with('success', 'Circuit updated.');

        }
        $request->validate([
            'guideName' => 'required',
            'guideFile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'resolutionName' => 'nullable',
            'resolutionFile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'datePublished' => 'required|date',
            
        ]);

        //$request->file('organigram')->store('organigram', 'public');
        Circuit::create([
            'guide_name' => $request->guideName,
            'guide_file' => $request->file('guideFile')->store('circuit/guides', 'public'),
            'resolution_name' => $request->resolutionName,
            'resolution_file' => $request->hasFile('resolutionFile') ? $request->file('resolutionFile')->store('circuit/resolutions', 'public') : null,
            'date_published' => $request->datePublished,
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

    public function destroy($id)
    {
        $circuit = Circuit::find($id);
        $circuit->delete();

        Storage::disk('public')->delete($circuit->guide_file);
        Storage::disk('public')->delete($circuit->resolution_file);
        
        return redirect()->back()->with('success', 'Circuit deleted.');
    }
}
