<?php

namespace App\Plugins\Kategori\Controllers;

use App\Plugins\Kategori\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KategoriController extends Controller
{
    public function index()
    {
        \Log::info('KategoriController@index accessed');
        
        try {
            $kategori = Kategori::orderBy('created_at', 'desc')->paginate(10);
            \Log::info('Kategori retrieved: ' . $kategori->count() . ' items');
        } catch (\Exception $e) {
            \Log::error('Error retrieving kategori: ' . $e->getMessage());
            throw $e;
        }

        return view('kategori::index', compact('kategori'));
    }

    public function create()
    {
        return view('kategori::create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'warna' => 'nullable|string|max:10',
            'ikon' => 'nullable|string|max:50',
            'aktif' => 'nullable|boolean'
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'warna' => $request->warna ?? '#007bff',
            'ikon' => $request->ikon ?? 'fas fa-tag',
            'aktif' => $request->has('aktif')
        ]);

        return redirect()->route('panel.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show($id)
    {
        $kategori = Kategori::findOrFail($id);

        return view('kategori::show', compact('kategori'));
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);

        return view('kategori::edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'warna' => 'nullable|string|max:10',
            'ikon' => 'nullable|string|max:50',
            'aktif' => 'nullable|boolean'
        ]);

        $kategori = Kategori::findOrFail($id);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'warna' => $request->warna ?? '#007bff',
            'ikon' => $request->ikon ?? 'fas fa-tag',
            'aktif' => $request->has('aktif')
        ]);

        return redirect()->route('panel.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        // Cek apakah kategori masih digunakan oleh berita
        $beritaCount = $kategori->berita()->count();
        if ($beritaCount > 0) {
            return redirect()->route('panel.kategori.index')->with('error', 'Kategori masih digunakan oleh ' . $beritaCount . ' berita, tidak dapat dihapus.');
        }

        $kategori->delete();

        return redirect()->route('panel.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }

    public function getActiveCategories()
    {
        $categories = Kategori::aktif()->orderBy('nama_kategori')->get(['id', 'nama_kategori']);
        return response()->json($categories);
    }
}