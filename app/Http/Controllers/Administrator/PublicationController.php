<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Models\PublicationDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PublicationController extends Controller
{
    protected $publication;

    public function __construct()
    {
        $this->publication = new Publication();
    }

    public function index(Request $request)
    {

        $perPage = $request->input('perPage', 10);
        $query = Publication::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('admin/publications/index', [
            'items' => $items,
            'headers' => $this->publication->headers,
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

                $publication = Publication::find($request->id);
                $publication->name = $request->name;
                $publication->description = $request->description;
                if ($request->hasFile('img_path')) {
                    $publication->img_path = $request->file('img_path')->store('publications', 'public');
                }

                foreach ($request->documents as $document) {
                    PublicationDocument::create([
                        'publication_id' => $publication->id,
                        'name' => $document['fileName'],
                        'file' => $document['file'][0]->store('documents/publications', 'public'),
                        'date_published' => $document['fileDate'],
                    ]);
                }

                $publication->save();
            } else {
                $request->validate([
                    'name' => 'required|string',
                    'description' => 'required|string',
                    'img_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                $publication = Publication::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'author' => auth()->user()->id,
                    'img_path' => $request->file('img_path')->store('publications', 'public'),
                ]);

                $documents = $request->documents ? $request->documents : [];

                foreach ($documents as $document) {
                    PublicationDocument::create([
                        'publication_id' => $publication->id,
                        'name' => $document['fileName'],
                        'file' => $document['file'][0]->store('documents/publications', 'public'),
                        'date_published' => $document['fileDate'],
                    ]);
                }
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
        $user = Publication::find($id);
        $user->is_active = !$user->is_active;
        $user->save();
        return redirect()->back()->with('success', 'Estado cambiado exitosamente.');
    }

    public function documentsDestroy($id, $document)
    {
        try {
            PublicationDocument::find($document)->delete();
            return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['Error al eliminar el elemento.', $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $user = Publication::find($id);
        $user->delete();
        return redirect()->back()->with('success', 'Elemento eliminado exitosamente.');
    }
}
