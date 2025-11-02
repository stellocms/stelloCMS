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
        
        // Use plugin namespace directly
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
        
        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }
    
    public function show($id)
    {
        $berita = Berita::findOrFail($id);
        
        return view('berita::show', compact('berita'));
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
        
        return redirect()->route('berita.index')->with('success', 'Berita berhasil diperbarui.');
    }
    
    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        
        // Hapus gambar jika ada
        if ($berita->gambar && file_exists(storage_path('app/public/' . $berita->gambar))) {
            unlink(storage_path('app/public/' . $berita->gambar));
        }
        
        $berita->delete();
        
        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}