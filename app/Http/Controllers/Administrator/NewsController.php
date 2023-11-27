<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NewsController extends Controller
{


    protected $news;
    public function __construct()
    {
        $this->news = new News();
    }
    public function index(Request $request)
    {

        $perPage = $request->input('perPage', 10);
        $query = News::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('title', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('admin/news/index', [
            'items' => $items,
            'headers' => $this->news->headers,
            'filters' => [
                'search' => $request->search,
            ],
        ]);
    }


    public function create()
    {

        return inertia('admin/news/create');
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

            $news = News::find($request->id);
            $news->title = $request->title;
            $news->description = $request->description;
            if ($request->file('image')) {
                $news->image = $request->file('image')->store('news', 'public');
            }
            $news->content = $request->content;
            $news->date_publish = $request->datePublish;
            $news->external_link = $request->externalLink;
            //del titulo sacar el slug
            $slug = strtolower($request->title);
            $slug = str_replace(' ', '-', $slug);
            $news->slug = $slug;
            $news->author = auth()->user()->id;
            $news->save();
        } else {

            $this->validate($request, [
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'image' => 'required|image|max:4024',
                'content' => 'required|string',
                'datePublish' => 'required|date',
                'externalLink' => 'nullable|url',
            ]);

            $news = new News();
            $news->title = $request->title;
            $news->description = $request->description;
            $news->image = $request->file('image')->store('news', 'public');
            $news->content = $request->content;
            $news->date_publish = $request->datePublish;
            $news->external_link = $request->externalLink;

            $slug = strtolower($request->title);
            $slug = str_replace(' ', '-', $slug);
            $news->slug = $slug;
            $news->author = auth()->user()->id;
            $news->save();
        }

        return redirect()->back()->with('success', 'Elemento creado exitosamente.');
    }

    public function edit($id)
    {
        $news = News::find($id);
        $news->datePublish = $news->date_publish;
        $news->externalLink = $news->external_link;
        $news->imageUrl = $news->image_url;
        $news->image = null;
        return inertia('admin/news/create', [
            'news' => $news
        ]);

    }

    public function destroy($id)
    {
        $news = News::find($id);
        $news->delete();
        return redirect()->back()
            ->with('success', 'Noticia eliminada exitosamente.');

    }

    public function changeState($id)
    {
        $user = News::find($id);
        $user->is_active = !$user->is_active;
        $user->save();
        return redirect()->back()->with('success', 'Estado cambiado exitosamente.');
    }
}
