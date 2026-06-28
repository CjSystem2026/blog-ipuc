<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class EventController extends Controller
{
    /**
     * Muestra la lista de eventos en el panel de administración.
     */
    public function index()
    {
        // Traer eventos ordenados por fecha ascendente (próximos eventos primero)
        $events = Event::orderBy('date', 'asc')->get();

        return Inertia::render('Events', [
            'events' => $events,
            'auth' => [
                'user' => auth()->user()
            ]
        ]);
    }

    /**
     * Guarda un nuevo evento en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
        }

        Event::create([
            'title' => $request->title,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
            'description' => $request->description,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Evento programado con éxito.');
    }

    /**
     * Actualiza un evento existente.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            // Eliminar imagen anterior si existe
            if ($event->image_path && Storage::disk('public')->exists($event->image_path)) {
                Storage::disk('public')->delete($event->image_path);
            }
            $data['image_path'] = $request->file('image')->store('events', 'public');
        }

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Evento actualizado con éxito.');
    }

    /**
     * Elimina un evento de la base de datos.
     */
    public function destroy(Event $event)
    {
        // Eliminar imagen asociada si existe
        if ($event->image_path && Storage::disk('public')->exists($event->image_path)) {
            Storage::disk('public')->delete($event->image_path);
        }

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Evento eliminado con éxito.');
    }
}
