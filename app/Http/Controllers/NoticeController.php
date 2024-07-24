<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::all();
        return view('admin.notice.index', compact('notices'));
    }

    public function create()
{
    $user = Auth::user();
    $gyms = [];

    if ($user->hasRole('Super Administrador')) {
        $gyms = Gym::all();
    } elseif ($user->hasRole('Administrador')) {
        $gyms = $user->gyms;
    } elseif ($user->hasRole('Staff')) {
        $gyms = $user->gyms->first(); // Asumiendo que Staff solo pertenece a un gimnasio
    }

    return view('admin.notice.create', compact('gyms', 'user'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_gym' => 'required|exists:gyms,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'isActive' => 'boolean',
        ]);

        $validated['id_user'] = Auth::id();

        Notice::create($validated);

        flash()->success('¡Aviso creado exitosamente!');
        return redirect()->route('notices.index');
    }

    public function show(Notice $notice)
    {
        return view('notices.show', compact('notice'));
    }

    public function edit($slug)
    {
        $notice = Notice::where('slug', $slug)->firstOrFail();
        $user = Auth::user();
        $gyms = [];

        if ($user->hasRole('Super Administrador')) {
            $gyms = Gym::all();
        } elseif ($user->hasRole('Administrador')) {
            $gyms = $user->gyms;
        } elseif ($user->hasRole('Staff')) {
            $gyms = $user->gyms->first(); // Asumiendo que Staff solo pertenece a un gimnasio
        }

        return view('admin.notice.edit', compact('notice', 'gyms', 'user'));
    }

    public function update(Request $request, $slug)
    {
        $notice = Notice::where('slug', $slug)->firstOrFail();
        $validated = $request->validate([
            'id_gym' => 'required|exists:gyms,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'isActive' => 'boolean',
        ]);

        $notice->update($validated);

        flash()->success('¡Aviso Editado exitosamente!');
        return redirect()->route('notices.index');
    }

    public function destroy($slug)
    {
        $notice = Notice::where('slug', $slug)->firstOrFail();
        $notice->delete();
        flash()->success('¡Aviso Eliminado exitosamente!');

        return redirect()->route('notices.index');
    }
}
