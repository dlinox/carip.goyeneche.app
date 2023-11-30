<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SliderController extends Controller
{

    protected $slider;
    public function __construct()
    {
        $this->slider = new Slider();
    }

    public function index(Request $request)
    {

        $perPage = $request->input('perPage', 10);
        $query = Slider::query();

        // Búsqueda por nombre de área
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('title', 'like', '%' . $searchTerm . '%');
        }

        // Obtener resultados paginados
        $items = $query->paginate($perPage)->appends($request->query());

        return Inertia::render('admin/sliders/index', [
            'items' => $items,
            'headers' => $this->slider->headers,
            'filters' => [
                'search' => $request->search,
            ],
        ]);
    }

    public function store(Request $request)
    {
        if($request->id ){
            $request->validate([
                'title' => 'required|string',
                'subtitle' => 'required|string',
                'link' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
       
            $slider = Slider::find($request->id);

            $slider->title = $request->title;
            $slider->subtitle = $request->subtitle;
            $slider->link = $request->link;

            if ($request->hasFile('image')) {
                $slider->image = $request->file('image')->store('sliders', 'public');
            }
            $slider->save();

            return redirect()->back()->with('success', 'Slider actualizado correctamente');
        }

        $request->validate([
            'title' => 'required|string',
            'subtitle' => 'required|string',
            'link' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $slider = Slider::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'link' => $request->link,
            'image' => $request->file('image')->store('sliders', 'public'),
        ]);
        return redirect()->back()->with('success', 'Slider creado correctamente');
    }

    public function changeState($id)
    {
        $user = Slider::find($id);
        $user->is_active = !$user->is_active;
        $user->save();
        return redirect()->back()->with('success', 'Estado cambiado exitosamente.');
    }

    public function destroy($id)
    {
        $slider = Slider::find($id);
        $slider->delete();
        Storage::disk('public')->delete($slider->image);
        return redirect()->back()->with('success', 'Slider eliminado correctamente');
    }
}
