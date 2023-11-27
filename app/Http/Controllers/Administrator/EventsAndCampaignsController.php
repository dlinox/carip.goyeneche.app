<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\EventsAndCampaigns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EventsAndCampaignsController extends Controller
{
    
    protected $eventsAndCampaigns;
    public function __construct()
    {
        $this->eventsAndCampaigns = new EventsAndCampaigns();
    }
    public function index(Request $request)
    {

        $perPage = $request->input('perPage', 10);
        $query = EventsAndCampaigns::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('title', 'like', '%' . $searchTerm . '%');
        }

        $user = Auth::user();

        if ($user->role === 'Operador'){
            $query->where('author', $user->id);
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('admin/eventsAndCampaigns/index', [
            'items' => $items,
            'headers' => $this->eventsAndCampaigns->headers,
            'filters' => [
                'search' => $request->search,
            ],
        ]);
    }


    public function create()
    {

        return inertia('admin/eventsAndCampaigns/create');
    }


    public function store(Request $request)
    {

        if ($request->id) {

            $this->validate($request, [
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'image' => 'nullable|image|max:4024',
                'content' => 'required|string',
                'datePublish' => 'required|date',
                'externalLink' => 'nullable|url',
            ]);

            $item = EventsAndCampaigns::find($request->id);
            $item->title = $request->title;
            $item->description = $request->description;
            if ($request->file('image')) {
                $item->image = $request->file('image')->store('EventsAndCampaigns', 'public');
            }
            $item->content = $request->content;
            $item->date_publish = $request->datePublish;
            $item->external_link = $request->externalLink;
            //del titulo sacar el slug
            $slug = strtolower($request->title);
            $slug = str_replace(' ', '-', $slug);
            $item->slug = $slug;
            $item->author = auth()->user()->id;
            $item->save();
        } else {

            $this->validate($request, [
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'image' => 'required|image|max:4024',
                'content' => 'required|string',
                'datePublish' => 'required|date',
                'externalLink' => 'nullable|url',
            ]);

            $item = new EventsAndCampaigns();
            $item->title = $request->title;
            $item->description = $request->description;
            $item->image = $request->file('image')->store('EventsAndCampaigns', 'public');
            $item->content = $request->content;
            $item->date_publish = $request->datePublish;
            $item->external_link = $request->externalLink;

            $slug = strtolower($request->title);
            $slug = str_replace(' ', '-', $slug);
            $item->slug = $slug;
            $item->author = auth()->user()->id;
            $item->save();
        }

        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function edit($id)
    {
        $item = EventsAndCampaigns::find($id);
        $item->datePublish = $item->date_publish;
        $item->externalLink = $item->external_link;
        $item->imageUrl = $item->image_url;
        $item->image = null;
        return inertia('admin/eventsAndCampaigns/create', [
            'item' => $item
        ]);

    }

    public function destroy($id)
    {
        $item = EventsAndCampaigns::find($id);
        $item->delete();
        return redirect()->back()
            ->with('success', 'Noticia eliminada exitosamente.');

    }

    public function changeState($id)
    {
        $user = EventsAndCampaigns::find($id);
        $user->is_active = !$user->is_active;
        $user->save();
        return redirect()->back()->with('success', 'Estado cambiado exitosamente.');
    }


}
