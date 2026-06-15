<?php

namespace App\Http\Controllers;

use App\Models\PrayerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrayerRequestController extends Controller
{
    public function index()
    {
        $prayers = PrayerRequest::published()
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('prayers.index', compact('prayers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|string|max:500',
        ]);

        PrayerRequest::create([
            'user_id' => Auth::id(),
            'body' => $request->body,
            'is_anonymous' => $request->has('is_anonymous'),
            'is_published' => false, // Require moderation
        ]);

        return back()->with('success', 'Tu petición ha sido enviada y llegará al equipo de intercesión. ¡Bendiciones!');
    }
}
