<?php

namespace App\Plugins\Berita\Controllers;

use App\Plugins\Berita\Models\Berita;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::where('aktif', true)->orderBy('tanggal_publikasi', 'desc')->paginate(10);

        return view('berita::index', compact('berita'));
    }

    public function create()
    {
        return view('berita::create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('berita', 'public');
            $data['gambar'] = $gambarPath;
        }

        Berita::create($data);

        $redirectUrl = in_array('panel.berita.index', array_keys(app('router')->getRoutes()->getRoutesByName())) ? 
            route('panel.berita.index') : url('/panel/berita');
        return redirect($redirectUrl)->with('success', 'Berita berhasil ditambahkan.');
    }

    public function show($id)
    {
        $berita = Berita::findOrFail($id);

        // Check if accessed via admin route or public route
        if (request()->routeIs('panel.berita.*')) {
            // If accessed from admin route, return admin view  
            return view('berita::show', compact('berita'));
        } else {
            // If accessed from public route, return frontend view
            return view('berita::frontend.show', compact('berita'));
        }
    }

    public function edit($id)
    {
        $berita = Berita::findOrFail($id);

        return view('berita::edit', compact('berita'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $berita = Berita::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($berita->gambar && file_exists(storage_path('app/public/' . $berita->gambar))) {
                unlink(storage_path('app/public/' . $berita->gambar));
            }

            $gambarPath = $request->file('gambar')->store('berita', 'public');
            $data['gambar'] = $gambarPath;
        }

        $berita->update($data);

        $redirectUrl = in_array('panel.berita.index', array_keys(app('router')->getRoutes()->getRoutesByName())) ? 
            route('panel.berita.index') : url('/panel/berita');
        return redirect($redirectUrl)->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        // Hapus gambar jika ada
        if ($berita->gambar && file_exists(storage_path('app/public/' . $berita->gambar))) {
            unlink(storage_path('app/public/' . $berita->gambar));
        }

        $berita->delete();

        $redirectUrl = in_array('panel.berita.index', array_keys(app('router')->getRoutes()->getRoutesByName())) ? 
            route('panel.berita.index') : url('/panel/berita');
        return redirect($redirectUrl)->with('success', 'Berita berhasil dihapus.');
    }

    public function publicIndex()
    {
        $berita = Berita::where('aktif', true)
                  ->orderBy('tanggal_publikasi', 'desc')
                  ->paginate(10);

        // Untuk view publik, kita gunakan view khusus frontend
        return view('berita::frontend.index', compact('berita'));
    }

    public function publicShow($id)
    {
        $berita = Berita::where('aktif', true)->findOrFail($id);

        return view('berita::frontend.show', compact('berita'));
    }
}