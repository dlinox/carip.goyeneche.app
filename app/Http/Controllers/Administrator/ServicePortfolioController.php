<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\ServicePortfolio;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServicePortfolioController extends Controller
{

    protected $servicePortfolio;
    public function __construct()
    {
        $this->servicePortfolio = new ServicePortfolio();
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $query = ServicePortfolio::query();
        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('guide_name', 'like', '%' . $searchTerm . '%');
        }
        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('admin/servicePortfolio/index', [
            'items' => $items,
            'headers' => $this->servicePortfolio->headers,
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
            'date_published' => 'required|date',
        ]);

        ServicePortfolio::create([
            'date_published' => $request->date_published,
            'guide_name' => $request->guideName,
            'guide_file' => $request->file('guideFile')->store('servicePorfolio/guide', 'public'),
            'resolution_name' => $request->resolutionName,
            'resolution_file' => $request->file('resolutionFile')->store('servicePorfolio/resolutions', 'public'),
        ]);

        return redirect()->back()->with('success', 'ServicePortfolio created.');
    }


    public function changeState($id)
    {
        $servicePortfolio = ServicePortfolio::find($id);
        $servicePortfolio->is_active = !$servicePortfolio->is_active;
        $servicePortfolio->save();

        return redirect()->back()->with('success', 'ServicePortfolio updated.');
    }
}
