<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\ServicePortfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $items = $query->select(
            'service_portfolios.id',
            'service_portfolios.date_published as datePublished',
            'service_portfolios.guide_name as guideName',
            'service_portfolios.guide_file as guideFile',
            'service_portfolios.resolution_name as resolutionName',
            'service_portfolios.resolution_file as resolutionFile',
            'service_portfolios.is_active as isActive',
        )
        ->paginate($perPage)
        ->appends($request->query());

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

        if($request->id){
            $request->validate([
                'guideName' => 'required',
                'guideFile' => 'nullable|file|mimes:pdf',
                'resolutionName' => 'required',
                'resolutionFile' => 'nullable|file|mimes:pdf',
                'datePublished' => 'required|date',
            ]);
            $servicePortfolio = ServicePortfolio::find($request->id);
            $servicePortfolio->date_published = $request->datePublished;
            $servicePortfolio->guide_name = $request->guideName;
            $servicePortfolio->resolution_name = $request->resolutionName;

            if($request->file('guideFile')){
                $servicePortfolio->guide_file = $request->file('guideFile')->store('servicePorfolio/guide', 'public');
            }
            if($request->file('resolutionFile')){
                $servicePortfolio->resolution_file = $request->file('resolutionFile')->store('servicePorfolio/resolutions', 'public');
            }
            $servicePortfolio->save();
            return redirect()->back()->with('success', 'ServicePortfolio updated.');
        }

        $request->validate([
            'guideName' => 'required',
            'guideFile' => 'required|file|mimes:pdf',
            'resolutionName' => 'required',
            'resolutionFile' => 'required|file|mimes:pdf',
            'datePublished' => 'required|date',
        ]);


        ServicePortfolio::create([
            'date_published' => $request->datePublished,
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

    public function destroy($id)
    {
        $servicePortfolio = ServicePortfolio::find($id);
        $servicePortfolio->delete();

        if(!$servicePortfolio){
            return redirect()->back()->with('error', 'ServicePortfolio not found.');
        }
        //eliminar los archiso del storage
        Storage::disk('public')->delete($servicePortfolio->guide_file);
        Storage::disk('public')->delete($servicePortfolio->resolution_file);

        return redirect()->back()->with('success', 'ServicePortfolio deleted.');
    }
}
