<?php

namespace App\Plugins\ContohPlugin\Controllers;

use App\Plugins\ContohPlugin\Models\ContohPlugin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContohPluginController extends Controller
{
    public function index()
    {
        $contohPlugins = ContohPlugin::where('aktif', true)->orderBy('tanggal_dibuat', 'desc')->paginate(10);
        
        return view('contohplugin::index', compact('contohPlugins'));
    }
    
    public function create()
    {
        return view('contohplugin::create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $data = $request->all();
        
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('contoh_plugins', 'public');
            $data['gambar'] = $gambarPath;
        }
        
        ContohPlugin::create($data);
        
        return redirect()->route('contohplugin.index')->with('success', 'Contoh Plugin berhasil ditambahkan.');
    }
    
    public function show($id)
    {
        $contohPlugin = ContohPlugin::findOrFail($id);
        
        return view('contohplugin::show', compact('contohPlugin'));
    }
    
    public function edit($id)
    {
        $contohPlugin = ContohPlugin::findOrFail($id);
        
        return view('contohplugin::edit', compact('contohPlugin'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $contohPlugin = ContohPlugin::findOrFail($id);
        $data = $request->all();
        
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($contohPlugin->gambar && file_exists(storage_path('app/public/' . $contohPlugin->gambar))) {
                unlink(storage_path('app/public/' . $contohPlugin->gambar));
            }
            
            $gambarPath = $request->file('gambar')->store('contoh_plugins', 'public');
            $data['gambar'] = $gambarPath;
        }
        
        $contohPlugin->update($data);
        
        return redirect()->route('contohplugin.index')->with('success', 'Contoh Plugin berhasil diperbarui.');
    }
    
    public function destroy($id)
    {
        $contohPlugin = ContohPlugin::findOrFail($id);
        
        // Hapus gambar jika ada
        if ($contohPlugin->gambar && file_exists(storage_path('app/public/' . $contohPlugin->gambar))) {
            unlink(storage_path('app/public/' . $contohPlugin->gambar));
        }
        
        $contohPlugin->delete();
        
        return redirect()->route('contohplugin.index')->with('success', 'Contoh Plugin berhasil dihapus.');
    }
}