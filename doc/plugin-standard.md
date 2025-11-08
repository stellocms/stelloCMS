# Dokumentasi Plugin Contoh - StelloCMS

Dokumentasi ini menyediakan panduan lengkap untuk membuat plugin baru di StelloCMS berdasarkan standar yang digunakan oleh sistem.

## Struktur Direktori Plugin

Sebuah plugin dalam StelloCMS harus mengikuti struktur direktori standar berikut:

```
app/Plugins/NamaPlugin/
├── Controllers/
│   └── NamaPluginController.php
├── Models/
│   └── NamaPlugin.php
├── Views/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── Database/
│   └── Migrations/
├── plugin.json
└── routes.php
```

## File Konfigurasi

### plugin.json
File ini sebenarnya adalah file PHP yang mengembalikan array konfigurasi plugin:

```php
<?php

return [
    'name' => 'NamaPlugin',
    'version' => '1.0.0',
    'description' => 'Deskripsi plugin',
    'author' => 'Nama Pengembang',
    'author_url' => 'https://contoh.com',
    'required_version' => '1.0.0',
    'database' => [
        'migrations' => 'Database/Migrations',
        'seeders' => 'Database/Seeders',
    ],
];
```

## Model Plugin

Model plugin harus mengikuti standar Eloquent Model:

```php
<?php

namespace App\Plugins\NamaPlugin\Models;

use Illuminate\Database\Eloquent\Model;

class NamaPlugin extends Model
{
    protected $fillable = [
        'kolom1',
        'kolom2',
        // daftar kolom yang bisa diisi
    ];
    
    protected $table = 'nama_tabel';
    
    protected $casts = [
        'field_boolean' => 'boolean',
        'field_datetime' => 'datetime',
        // konversi tipe data
    ];
}
```

## Controller Plugin

Controller plugin harus mengikuti standar Laravel dan menggunakan namespace yang benar:

```php
<?php

namespace App\Plugins\NamaPlugin\Controllers;

use App\Plugins\NamaPlugin\Models\NamaPlugin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NamaPluginController extends Controller
{
    public function index()
    {
        $data = NamaPlugin::orderBy('created_at', 'desc')->paginate(10);
        return view('namaplugin::index', compact('data'));
    }

    public function create()
    {
        return view('namaplugin::create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // aturan validasi
        ]);

        $data = $request->all();
        // logika penyimpanan data

        NamaPlugin::create($data);

        return redirect()->route('namaplugin.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = NamaPlugin::findOrFail($id);
        return view('namaplugin::edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // aturan validasi
        ]);

        $item = NamaPlugin::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('namaplugin.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = NamaPlugin::findOrFail($id);
        $item->delete();

        return redirect()->route('namaplugin.index')->with('success', 'Data berhasil dihapus.');
    }
}
```

## Routes Plugin

File routes.php harus mengikuti format berikut:

```php
<?php

use App\Plugins\NamaPlugin\Controllers\NamaPluginController;
use Illuminate\Support\Facades\Route;

Route::prefix('panel/nama-plugin')->middleware(['auth'])->group(function () {
    Route::get('/', [NamaPluginController::class, 'index'])->name('namaplugin.index');
    Route::get('/create', [NamaPluginController::class, 'create'])->name('namaplugin.create');
    Route::post('/', [NamaPluginController::class, 'store'])->name('namaplugin.store');
    Route::get('/{id}/edit', [NamaPluginController::class, 'edit'])->name('namaplugin.edit');
    Route::put('/{id}', [NamaPluginController::class, 'update'])->name('namaplugin.update');
    Route::delete('/{id}', [NamaPluginController::class, 'destroy'])->name('namaplugin.destroy');
});
```

## View Plugin

View plugin menggunakan namespace plugin. Jika nama plugin adalah 'NamaPlugin', maka namespace view adalah 'namaplugin::'.

Contoh struktur view:

```blade
@extends('theme.admin.' . config('themes.admin') . '::layouts.app')

@section('title', 'Judul Halaman - ' . cms_name())
@section('page_title', 'Judul Halaman')

@section('content')
<div class="container-fluid">
    <!-- Konten plugin -->
</div>
@endsection
```

## Pendaftaran Plugin ke Database

Agar plugin bisa diakses, tambahkan entri plugin ke tabel plugins di database:

```php
$plugin = \App\Models\Plugin::firstOrCreate(
    ['name' => 'NamaPlugin'],
    [
        'title' => 'Nama Plugin',
        'version' => '1.0.0',
        'description' => 'Deskripsi plugin',
        'author' => 'Pengembang',
        'author_url' => 'https://contoh.com',
        'category' => 'utility',
        'tags' => json_encode(['tag1', 'tag2']),
        'installed' => true,
        'active' => true,
    ]
);
```

## Tips Pengembangan Plugin

1. Selalu gunakan namespace yang sesuai dengan struktur direktori plugin
2. Gunakan format view namespace yang konsisten dengan nama plugin
3. Ikuti konvensi penamaan rute: `{plugin_name}.{action}`
4. Tambahkan middleware auth untuk akses panel admin
5. Gunakan prefix panel untuk rute plugin
6. Pastikan plugin diinstal dan diaktifkan melalui PluginManager
7. Gunakan format blade.php untuk file view

Dengan mengikuti standar ini, plugin Anda akan dapat berintegrasi dengan baik dengan sistem StelloCMS dan akan muncul di sidebar setelah diaktifkan.