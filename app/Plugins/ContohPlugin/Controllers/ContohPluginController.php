<?php

namespace App\Plugins\ContohPlugin\Controllers;

use App\Plugins\ContohPlugin\Models\ContohPlugin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ContohPluginController extends Controller
{
    public function index()
    {
        try {
            $contohPlugins = ContohPlugin::where('aktif', true)->orderBy('tanggal_dibuat', 'desc')->paginate(10);
            
            return view('contohplugin::index', compact('contohPlugins'));
        } catch (\Exception $e) {
            Log::error('Error in ContohPluginController@index: ' . $e->getMessage());
            throw $e;
        }
    }
    
    public function create()
    {
        try {
            return view('contohplugin::create');
        } catch (\Exception $e) {
            Log::error('Error in ContohPluginController@create: ' . $e->getMessage());
            throw $e;
        }
    }
    
    public function store(Request $request)
    {
        try {
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
            
            $redirectUrl = in_array('panel.contohplugin.index', array_keys(app('router')->getRoutes()->getRoutesByName())) ? 
                route('panel.contohplugin.index') : url('/panel/contohplugin');
            return redirect($redirectUrl)->with('success', 'Contoh Plugin berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error in ContohPluginController@store: ' . $e->getMessage());
            throw $e;
        }
    }
    
    public function show($id)
    {
        try {
            $contohPlugin = ContohPlugin::findOrFail($id);
            
            return view('contohplugin::show', compact('contohPlugin'));
        } catch (\Exception $e) {
            Log::error('Error in ContohPluginController@show: ' . $e->getMessage());
            throw $e;
        }
    }
    
    public function edit($id)
    {
        try {
            $contohPlugin = ContohPlugin::findOrFail($id);
            
            return view('contohplugin::edit', compact('contohPlugin'));
        } catch (\Exception $e) {
            Log::error('Error in ContohPluginController@edit: ' . $e->getMessage());
            throw $e;
        }
    }
    
    public function update(Request $request, $id)
    {
        try {
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
            
            $redirectUrl = in_array('panel.contohplugin.index', array_keys(app('router')->getRoutes()->getRoutesByName())) ? 
                route('panel.contohplugin.index') : url('/panel/contohplugin');
            return redirect($redirectUrl)->with('success', 'Contoh Plugin berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error in ContohPluginController@update: ' . $e->getMessage());
            throw $e;
        }
    }
    
    public function destroy($id)
    {
        try {
            $contohPlugin = ContohPlugin::findOrFail($id);
            
            // Hapus gambar jika ada
            if ($contohPlugin->gambar && file_exists(storage_path('app/public/' . $contohPlugin->gambar))) {
                unlink(storage_path('app/public/' . $contohPlugin->gambar));
            }
            
            $contohPlugin->delete();
            
            $redirectUrl = in_array('panel.contohplugin.index', array_keys(app('router')->getRoutes()->getRoutesByName())) ? 
                route('panel.contohplugin.index') : url('/panel/contohplugin');
            return redirect($redirectUrl)->with('success', 'Contoh Plugin berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error in ContohPluginController@destroy: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Frontend methods
     */
    
    public function frontpageIndex()
    {
        try {
            $contohPlugins = ContohPlugin::where('aktif', true)
                ->orderBy('tanggal_dibuat', 'desc')
                ->paginate(9); // 9 items per page for grid layout
            
            return view('contohplugin::frontpage.index', compact('contohPlugins'));
        } catch (\Exception $e) {
            Log::error('Error in ContohPluginController@frontpageIndex: ' . $e->getMessage());
            throw $e;
        }
    }
    
    public function frontpageShow($slug)
    {
        try {
            $contohPlugin = ContohPlugin::where('aktif', true)->bySlug($slug)->firstOrFail();
            
            return view('contohplugin::frontpage.show', compact('contohPlugin'));
        } catch (\Exception $e) {
            Log::error('Error in ContohPluginController@frontpageShow: ' . $e->getMessage());
            throw $e;
        }
    }
}