<?php

namespace App\Http\Controllers;

use App\Models\PrayerRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PrayerRequestController extends Controller
{
    /**
     * Muestra las peticiones de oración en el panel de administración.
     */
    public function index()
    {
        $prayerRequests = PrayerRequest::latest()->get();

        return Inertia::render('PrayerRequests', [
            'prayerRequests' => $prayerRequests,
            'auth' => [
                'user' => auth()->user()
            ]
        ]);
    }

    /**
     * Guarda una nueva petición de oración desde el sitio público.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'message' => 'required|string|max:1000',
            'is_private' => 'nullable|boolean',
        ]);

        $name = $request->name;
        $email = $request->email;

        if (auth()->check()) {
            $name = auth()->user()->name;
            $email = auth()->user()->email;
        }

        $prayerRequest = PrayerRequest::create([
            'name' => $name ?: 'Anónimo',
            'email' => $email,
            'message' => $request->message,
            'is_private' => $request->boolean('is_private'),
            'status' => 'pending',
        ]);

        if (!$prayerRequest->is_private) {
            broadcast(new \App\Events\ResourceCreated('prayer', 'Nueva Petición de Oración de ' . $prayerRequest->name, route('prayer-requests.show', $prayerRequest->id)))->toOthers();
        }

        return back()->with('success', 'Tu petición de oración ha sido recibida. Estaremos intercediendo por ti.');
    }

    /**
     * Actualiza el estado de una petición de oración (marcar como orado o respondido).
     */
    public function update(Request $request, PrayerRequest $prayerRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,prayed,answered',
        ]);

        $prayerRequest->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Petición de oración actualizada con éxito.');
    }

    /**
     * Elimina una petición de oración.
     */
    public function destroy(PrayerRequest $prayerRequest)
    {
        // Solo administradores pueden eliminar peticiones de oración
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Acción no autorizada.');
        }

        $prayerRequest->delete();

        return back()->with('success', 'Petición de oración eliminada con éxito.');
    }

    /**
     * Muestra la lista pública de peticiones de oración no privadas (Blade).
     */
    public function publicIndex()
    {
        $prayerRequests = PrayerRequest::where('is_private', false)->latest()->get();
        return view('prayer_requests.index', compact('prayerRequests'));
    }

    /**
     * Muestra una petición de oración individual no privada (Blade).
     */
    public function publicShow($id)
    {
        $prayerRequest = PrayerRequest::with('comments.user')->findOrFail($id);

        if ($prayerRequest->is_private) {
            abort(404);
        }

        return view('prayer_requests.show', compact('prayerRequest'));
    }
}
