<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TestimonialController extends Controller
{
    /**
     * Muestra la lista de testimonios en el panel de administración.
     */
    public function index()
    {
        $testimonials = Testimonial::latest()->get();

        return Inertia::render('Testimonials', [
            'testimonials' => $testimonials,
            'auth' => [
                'user' => auth()->user()
            ]
        ]);
    }

    /**
     * Guarda un nuevo testimonio enviado desde el sitio público (pendiente de aprobación).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'content' => 'required|string|max:2000',
        ]);

        Testimonial::create([
            'name' => $request->name ?: 'Anónimo',
            'content' => $request->content,
            'status' => 'pending', // por defecto pendiente de moderación
        ]);

        return redirect()->route('testimonials.index')->with('success', 'Tu testimonio ha sido enviado con éxito y está pendiente de revisión. ¡Gracias por compartir lo que Dios ha hecho!');
    }

    /**
     * Actualiza el estado del testimonio (Aprobar, Archivar, etc.).
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,archived',
        ]);

        $testimonial->update([
            'status' => $request->status,
        ]);

        if ($request->status === 'approved') {
            broadcast(new \App\Events\ResourceCreated('testimonial', 'Nuevo Testimonio de ' . $testimonial->name, route('testimonials.show', $testimonial->id)))->toOthers();
        }

        return back()->with('success', 'Testimonio actualizado con éxito.');
    }

    /**
     * Elimina permanentemente un testimonio de la base de datos.
     */
    public function destroy(Testimonial $testimonial)
    {
        // Solo administradores pueden eliminar testimonios
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Acción no autorizada.');
        }

        $testimonial->delete();

        return back()->with('success', 'Testimonio eliminado con éxito.');
    }

    /**
     * Muestra la lista pública de testimonios aprobados (Blade).
     */
    public function publicIndex()
    {
        $testimonials = Testimonial::where('status', 'approved')->latest()->get();
        return view('testimonials.index', compact('testimonials'));
    }

    /**
     * Muestra el formulario para redactar un testimonio (Blade).
     */
    public function publicCreate()
    {
        return view('testimonials.create');
    }

    /**
     * Muestra un testimonio individual aprobado (Blade).
     */
    public function publicShow($id)
    {
        $testimonial = Testimonial::with('comments.user')->findOrFail($id);

        if ($testimonial->status !== 'approved') {
            abort(404);
        }

        return view('testimonials.show', compact('testimonial'));
    }
}
