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
        \Log::info('BeritaController@store called');
        \Log::info('Request data keys: ' . implode(', ', array_keys($request->all())));
        \Log::info('Has file gambar: ' . ($request->hasFile('gambar') ? 'true' : 'false'));
        \Log::info('Has unsplash_image_url: ' . ($request->has('unsplash_image_url') ? 'true' : 'false'));
        
        if ($request->has('unsplash_image_url')) {
            \Log::info('Unsplash image URL value: ' . $request->unsplash_image_url);
        }

        $rules = [
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:berita',
        ];
        
        // Tambahkan validasi kategori_id hanya jika plugin kategori terinstal
        if (class_exists(\App\Plugins\Kategori\Models\Kategori::class)) {
            $rules['kategori_id'] = 'nullable|numeric|exists:kategori_berita,id';
        }

        // Tambahkan validasi gambar hanya jika bukan dari Unsplash
        if ($request->hasFile('gambar')) {
            $rules['gambar'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        $request->validate($rules);

        $data = $request->except(['unsplash_image_url', '_token', '_method']); // Exclude fields that shouldn't be saved directly to the model
        
        // Pastikan hanya field yang divalidasi yang disimpan
        $allowedFields = array_keys($rules);
        $data = array_intersect_key($data, array_flip($allowedFields));
        
        // Pastikan hanya field yang divalidasi yang disimpan
        $allowedFields = array_keys($rules);
        $data = array_intersect_key($data, array_flip($allowedFields));

        // Handle upload dari komputer pengguna
        if ($request->hasFile('gambar')) {
            $judul = $request->judul ?? 'berita';
            $slug = \Illuminate\Support\Str::slug($judul, '_');
            
            // Dapatkan file yang diunggah
            $uploadedFile = $request->file('gambar');
            $extension = $uploadedFile->getClientOriginalExtension();
            
            // Buat nama file unik
            $uniqueFilename = time() . '_' . $slug;
            
            // Simpan file sementara untuk diproses
            $tempPath = $uploadedFile->store('temp', 'public');
            $fullTempPath = storage_path('app/public/' . $tempPath);
            
            // Buat thumbnail dengan watermark menggunakan helper
            $targetDirectory = 'berita';
            
            // Generate thumbnails
            $thumbnails = \App\Helpers\ImageHelper::generateThumbnailsWithWatermark(
                $fullTempPath,
                $targetDirectory,
                $uniqueFilename,
                $extension
            );
            
            // Gunakan thumbnail dengan ukuran 800px sebagai gambar utama
            $largeThumb = collect($thumbnails)->first(function($thumb) {
                return strpos($thumb, '_thumb_large') !== false;
            });
            
            if ($largeThumb) {
                $data['gambar'] = $largeThumb;
            }
            
            // Hapus file sementara setelah diproses
            if (file_exists($fullTempPath)) {
                unlink($fullTempPath);
            }
            // Hapus dari storage temp juga
            Storage::disk('public')->delete($tempPath);
        } 
        // Handle gambar dari Unsplash URL - download ke local saat disimpan
        elseif ($request->has('unsplash_image_url')) {
            \Log::info('Processing Unsplash URL: ' . $request->unsplash_image_url);
            \Log::info('Unsplash URL detected: ' . $request->unsplash_image_url);
            
            $imageUrl = $request->unsplash_image_url;
            
            // Coba beberapa pendekatan untuk download gambar
            $imageContent = null;
            
            // Pendekatan 1: cURL dengan header tambahan
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $imageUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
            curl_setopt($ch, CURLOPT_REFERER, 'https://unsplash.com/');
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_HEADER, false);
            
            $imageContent = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE) ?? '';
            $error = curl_error($ch);
            curl_close($ch);
            
            \Log::info('CURL Response - HTTP Code: ' . $httpCode . ', Content-Type: ' . $contentType . ', Error: ' . $error . ', Content Length: ' . ($imageContent !== null ? strlen($imageContent) : 0));
            
            // Jika cURL gagal, coba pendekatan file_get_contents dengan konteks
            if ($imageContent === false || $httpCode !== 200) {
                \Log::info('cURL failed, trying file_get_contents with context');
                
                try {
                    $context = stream_context_create([
                        'http' => [
                            'method' => 'GET',
                            'header' => [
                                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                                'Referer: https://unsplash.com/',
                                'Accept: image/webp,image/apng,image/*,*/*;q=0.8'
                            ],
                            'timeout' => 30
                        ]
                    ]);
                    
                    $imageContent = file_get_contents($imageUrl, false, $context);
                    $httpCode = $imageContent !== false ? 200 : 0;
                    
                    \Log::info('file_get_contents result - Content Length: ' . ($imageContent !== null ? strlen($imageContent) : 0));
                } catch (\Exception $e) {
                    \Log::error('Exception in file_get_contents: ' . $e->getMessage());
                    $imageContent = null;
                }
            }
            
            if ($imageContent !== false && $imageContent !== null && $httpCode === 200) {
                $judul = $request->judul ?? 'unsplash_image';
                $slug = \Illuminate\Support\Str::slug($judul, '_');
                
                // Deteksi ekstensi dari header content-type
                $extension = 'jpg'; // default
                if (strpos($contentType, 'png') !== false) {
                    $extension = 'png';
                } elseif (strpos($contentType, 'gif') !== false) {
                    $extension = 'gif';
                } elseif (strpos($contentType, 'jpeg') !== false || strpos($contentType, 'jpg') !== false) {
                    $extension = 'jpg';
                }
                
                // Buat nama file yang unik berdasarkan slug judul
                $filename = time() . '_' . $slug;
                $tempPath = 'temp/' . $filename . '.' . $extension;

                // Simpan sementara untuk diproses
                $result = \Illuminate\Support\Facades\Storage::disk('public')->put($tempPath, $imageContent);
                
                if ($result) {
                    $fullTempPath = storage_path('app/public/' . $tempPath);
                    
                    // Buat thumbnail dengan watermark menggunakan helper
                    $targetDirectory = 'berita';
                    
                    // Generate thumbnails
                    $thumbnails = \App\Helpers\ImageHelper::generateThumbnailsWithWatermark(
                        $fullTempPath,
                        $targetDirectory,
                        $filename,
                        $extension
                    );
                    
                    // Gunakan thumbnail dengan ukuran 800px sebagai gambar utama
                    $largeThumb = collect($thumbnails)->first(function($thumb) {
                        return strpos($thumb, '_thumb_large') !== false;
                    });
                    
                    if ($largeThumb) {
                        $data['gambar'] = $largeThumb;
                        \Log::info('Image with watermark saved successfully, path: ' . $largeThumb);
                    }
                    
                    // Hapus file sementara setelah diproses
                    if (file_exists($fullTempPath)) {
                        unlink($fullTempPath);
                    }
                    // Hapus dari storage temp juga
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($tempPath);
                } else {
                    \Log::error('Failed to save image to temporary storage');
                }
            } else {
                \Log::error('Failed to download image from URL. HTTP Code: ' . $httpCode . ', Error: ' . $error);
            }
        }

        // Set viewer to 0 for new records
        $data['viewer'] = 0;

        // Hapus field kategori_id dari data jika plugin kategori tidak terinstal
        if (!class_exists(\App\Plugins\Kategori\Models\Kategori::class)) {
            unset($data['kategori_id']);
        }

        $berita = Berita::create($data);

        \Log::info('Berita created with ID: ' . $berita->id . ', gambar path: ' . ($berita->gambar ?? 'null'));

        $redirectUrl = in_array('panel.berita.index', array_keys(app('router')->getRoutes()->getRoutesByName())) ?
            route('panel.berita.index') : url('/panel/berita');
        return redirect($redirectUrl)->with('success', 'Berita berhasil ditambahkan.');
    }

    public function show($id)
    {
        // Check if the parameter is numeric (ID) or string (slug)
        if (is_numeric($id)) {
            $berita = Berita::findOrFail($id);
        } else {
            $berita = Berita::bySlug($id)->firstOrFail();
        }

        // Check if accessed via admin route or public route
        if (request()->routeIs('panel.berita.*')) {
            // If accessed from admin route, return admin view
            return view_theme('admin', 'berita.show', compact('berita'));
        } else {
            // If accessed from public route, return frontend view
            return view_theme('frontend', 'berita.frontend.show', compact('berita'));
        }
    }

    public function edit($id)
    {
        $berita = Berita::findOrFail($id);

        return view('berita::edit', compact('berita'));
    }

    public function update(Request $request, $id)
    {
        \Log::info('BeritaController@update called for ID: ' . $id);
        \Log::info('Request data keys: ' . implode(', ', array_keys($request->all())));
        \Log::info('Has file gambar: ' . ($request->hasFile('gambar') ? 'true' : 'false'));
        \Log::info('Has unsplash_image_url: ' . ($request->has('unsplash_image_url') ? 'true' : 'false'));
        
        if ($request->has('unsplash_image_url')) {
            \Log::info('Unsplash image URL value: ' . $request->unsplash_image_url);
        }

        $berita = Berita::findOrFail($id);
        
        $rules = [
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:berita,slug,' . $id,
        ];
        
        // Tambahkan validasi kategori_id hanya jika plugin kategori terinstal
        if (class_exists(\App\Plugins\Kategori\Models\Kategori::class)) {
            $rules['kategori_id'] = 'nullable|numeric|exists:kategori_berita,id';
        }

        // Tambahkan validasi gambar hanya jika bukan dari Unsplash
        if ($request->hasFile('gambar')) {
            $rules['gambar'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        $request->validate($rules);

        $data = $request->except(['unsplash_image_url']); // Exclude the URL field from being saved directly to the model

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($berita->gambar && file_exists(storage_path('app/public/' . $berita->gambar))) {
                unlink(storage_path('app/public/' . $berita->gambar));
            }

            $judul = $request->judul ?? 'berita';
            $slug = \Illuminate\Support\Str::slug($judul, '_');
            
            // Dapatkan file yang diunggah
            $uploadedFile = $request->file('gambar');
            $extension = $uploadedFile->getClientOriginalExtension();
            
            // Buat nama file unik
            $uniqueFilename = time() . '_' . $slug;
            
            // Simpan file sementara untuk diproses
            $tempPath = $uploadedFile->store('temp', 'public');
            $fullTempPath = storage_path('app/public/' . $tempPath);
            
            // Buat thumbnail dengan watermark menggunakan helper
            $targetDirectory = 'berita';
            
            // Generate thumbnails
            $thumbnails = \App\Helpers\ImageHelper::generateThumbnailsWithWatermark(
                $fullTempPath,
                $targetDirectory,
                $uniqueFilename,
                $extension
            );
            
            // Gunakan thumbnail dengan ukuran 800px sebagai gambar utama
            $largeThumb = collect($thumbnails)->first(function($thumb) {
                return strpos($thumb, '_thumb_large') !== false;
            });
            
            if ($largeThumb) {
                $data['gambar'] = $largeThumb;
            }
            
            // Hapus file sementara setelah diproses
            if (file_exists($fullTempPath)) {
                unlink($fullTempPath);
            }
            // Hapus dari storage temp juga
            Storage::disk('public')->delete($tempPath);
        } 
        // Handle gambar dari Unsplash URL - download ke local saat update
        elseif ($request->has('unsplash_image_url')) {
            \Log::info('Unsplash URL detected in update: ' . $request->unsplash_image_url);
            
            $imageUrl = $request->unsplash_image_url;
            
            // Hapus gambar lama jika ada
            if ($berita->gambar && file_exists(storage_path('app/public/' . $berita->gambar))) {
                unlink(storage_path('app/public/' . $berita->gambar));
                \Log::info('Old image deleted: ' . $berita->gambar);
            }
            
            // Coba beberapa pendekatan untuk download gambar
            $imageContent = null;
            
            // Pendekatan 1: cURL dengan header tambahan
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $imageUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
            curl_setopt($ch, CURLOPT_REFERER, 'https://unsplash.com/');
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_HEADER, false);
            
            $imageContent = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE) ?? '';
            $error = curl_error($ch);
            curl_close($ch);
            
            \Log::info('CURL Response in update - HTTP Code: ' . $httpCode . ', Content-Type: ' . $contentType . ', Error: ' . $error . ', Content Length: ' . ($imageContent !== null ? strlen($imageContent) : 0));
            
            // Jika cURL gagal, coba pendekatan file_get_contents dengan konteks
            if ($imageContent === false || $httpCode !== 200) {
                \Log::info('cURL failed in update, trying file_get_contents with context');
                
                try {
                    $context = stream_context_create([
                        'http' => [
                            'method' => 'GET',
                            'header' => [
                                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                                'Referer: https://unsplash.com/',
                                'Accept: image/webp,image/apng,image/*,*/*;q=0.8'
                            ],
                            'timeout' => 30
                        ]
                    ]);
                    
                    $imageContent = file_get_contents($imageUrl, false, $context);
                    $httpCode = $imageContent !== false ? 200 : 0;
                    
                    \Log::info('file_get_contents result in update - Content Length: ' . ($imageContent !== null ? strlen($imageContent) : 0));
                } catch (\Exception $e) {
                    \Log::error('Exception in file_get_contents in update: ' . $e->getMessage());
                    $imageContent = null;
                }
            }
            
            if ($imageContent !== false && $imageContent !== null && $httpCode === 200) {
                $judul = $request->judul ?? 'unsplash_image';
                $slug = \Illuminate\Support\Str::slug($judul, '_');
                
                // Deteksi ekstensi dari header content-type
                $extension = 'jpg'; // default
                if (strpos($contentType, 'png') !== false) {
                    $extension = 'png';
                } elseif (strpos($contentType, 'gif') !== false) {
                    $extension = 'gif';
                } elseif (strpos($contentType, 'jpeg') !== false || strpos($contentType, 'jpg') !== false) {
                    $extension = 'jpg';
                }
                
                // Buat nama file yang unik berdasarkan slug judul
                $filename = time() . '_' . $slug;
                $tempPath = 'temp/' . $filename . '.' . $extension;

                // Simpan sementara untuk diproses
                $result = \Illuminate\Support\Facades\Storage::disk('public')->put($tempPath, $imageContent);
                
                if ($result) {
                    $fullTempPath = storage_path('app/public/' . $tempPath);
                    
                    // Buat thumbnail dengan watermark menggunakan helper
                    $targetDirectory = 'berita';
                    
                    // Generate thumbnails
                    $thumbnails = \App\Helpers\ImageHelper::generateThumbnailsWithWatermark(
                        $fullTempPath,
                        $targetDirectory,
                        $filename,
                        $extension
                    );
                    
                    // Gunakan thumbnail dengan ukuran 800px sebagai gambar utama
                    $largeThumb = collect($thumbnails)->first(function($thumb) {
                        return strpos($thumb, '_thumb_large') !== false;
                    });
                    
                    if ($largeThumb) {
                        $data['gambar'] = $largeThumb;
                        \Log::info('Image with watermark saved successfully in update, path: ' . $largeThumb);
                    }
                    
                    // Hapus file sementara setelah diproses
                    if (file_exists($fullTempPath)) {
                        unlink($fullTempPath);
                    }
                    // Hapus dari storage temp juga
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($tempPath);
                } else {
                    \Log::error('Failed to save image to temporary storage in update');
                }
            } else {
                \Log::error('Failed to download image from URL in update. HTTP Code: ' . $httpCode . ', Error: ' . $error);
            }
        }

        // Hapus field kategori_id dari data jika plugin kategori tidak terinstal
        if (!class_exists(\App\Plugins\Kategori\Models\Kategori::class)) {
            unset($data['kategori_id']);
        }

        $berita->update($data);

        \Log::info('Berita updated with ID: ' . $berita->id . ', gambar path: ' . ($berita->gambar ?? 'null'));

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

        // Untuk view publik, kita gunakan view khusus frontend melalui helper view_theme
        return view_theme('frontend', 'berita.frontend.index', compact('berita'));
    }

    public function publicShow($slug)
    {
        $berita = Berita::where('aktif', true)->bySlug($slug)->firstOrFail();

        // Increment viewer count
        $berita->increment('viewer');

        return view_theme('frontend', 'berita.frontend.show', compact('berita'));
    }

    public function searchUnsplash(Request $request)
    {
        // Ambil pengaturan dari tabel settings
        $accessKey = \App\Models\Setting::where('pengaturan', 'unsplash-access')->first();
        $secretKey = \App\Models\Setting::where('pengaturan', 'unsplash-secret')->first();

        \Log::info('Unsplash search called - Access key exists: ' . ($accessKey ? 'true' : 'false') . ', Secret key exists: ' . ($secretKey ? 'true' : 'false'));

        if (!$accessKey || !$secretKey) {
            \Log::error('Unsplash API keys not configured');
            return response()->json(['error' => 'Unsplash API keys not configured'], 400);
        }

        $query = $request->query('query', 'random'); // Gunakan query dari judul atau random
        $perPage = $request->query('per_page', 12);

        $url = "https://api.unsplash.com/search/photos?query=" . urlencode($query) . "&per_page={$perPage}&client_id=" . urlencode($accessKey->nilai);

        \Log::info('Unsplash API URL: ' . $url);

        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => [
                    'Accept: application/json',
                    'User-Agent: stelloCMS/1.0',
                    'Authorization: Client-ID ' . $accessKey->nilai
                ],
                'timeout' => 10
            ]
        ]);

        $response = @file_get_contents($url, false, $context);
        
        \Log::info('Unsplash API response length: ' . ($response !== false ? strlen($response) : 'false'));

        if ($response === false) {
            \Log::error('Failed to fetch images from Unsplash');
            return response()->json(['error' => 'Failed to fetch images from Unsplash'], 500);
        }

        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            \Log::error('Invalid response from Unsplash: ' . json_last_error_msg());
            return response()->json(['error' => 'Invalid response from Unsplash'], 500);
        }

        return response()->json($data);
    }


    
    public function checkUnsplashKeys()
    {
        try {
            $accessKey = \App\Models\Setting::where('pengaturan', 'unsplash-access')->first();
            $secretKey = \App\Models\Setting::where('pengaturan', 'unsplash-secret')->first();

            $hasKeys = $accessKey && $secretKey && !empty($accessKey->nilai) && !empty($secretKey->nilai);
        } catch (\Exception $e) {
            $hasKeys = false;
        }

        return response()->json(['hasKeys' => $hasKeys]);
    }

    /**
     * Fungsi untuk mendapatkan widget berita terbaru
     */
    public function getLatestNewsWidget($limit = 5)
    {
        // Ambil berita aktif terbaru
        $latestNews = Berita::where('aktif', true)
                            ->orderBy('tanggal_publikasi', 'desc')
                            ->limit($limit)
                            ->get(['id', 'judul', 'tanggal_publikasi', 'gambar', 'slug']);

        return view('berita::widget.latest-news', compact('latestNews'))->render();
    }

    /**
     * Fungsi untuk mendapatkan data berita terbaru (API untuk widget)
     */
    public function getLatestNewsData($limit = 5)
    {
        $latestNews = Berita::where('aktif', true)
                            ->orderBy('tanggal_publikasi', 'desc')
                            ->limit($limit)
                            ->get(['id', 'judul', 'tanggal_publikasi', 'gambar', 'slug', 'isi']);

        return response()->json($latestNews);
    }

    /**
     * Fungsi untuk mendapatkan widget berita populer
     */
    public function getPopularNewsWidget($limit = 5)
    {
        // Ambil berita aktif yang paling banyak dilihat (berdasarkan kolom viewer)
        $popularNews = Berita::where('aktif', true)
                            ->orderBy('viewer', 'desc')
                            ->limit($limit)
                            ->get(['id', 'judul', 'tanggal_publikasi', 'gambar', 'slug', 'viewer']);

        return view('berita::widget.popular-news', compact('popularNews'))->render();
    }

    /**
     * Fungsi untuk mendapatkan data berita populer (API untuk widget)
     */
    public function getPopularNewsData($limit = 5)
    {
        $popularNews = Berita::where('aktif', true)
                            ->orderBy('viewer', 'desc')
                            ->limit($limit)
                            ->get(['id', 'judul', 'tanggal_publikasi', 'gambar', 'slug', 'viewer']);

        return response()->json($popularNews);
    }

    /**
     * Fungsi untuk mendapatkan widget berita acak yang memiliki gambar
     */
    public function getRandomNewsWidget($limit = 1)
    {
        // Ambil berita aktif yang memiliki gambar secara acak
        $totalWithImages = Berita::where('aktif', true)
                                  ->whereNotNull('gambar')
                                  ->where('gambar', '!=', '')
                                  ->count();

        if ($totalWithImages == 0) {
            // Jika tidak ada berita dengan gambar, kembalikan template kosong
            return view('berita::widget.random-news', ['randomNews' => collect([])])->render();
        }

        // Ambil offset acak
        $randomOffset = rand(0, max(0, $totalWithImages - 1));
        
        $randomNews = Berita::where('aktif', true)
                           ->whereNotNull('gambar')
                           ->where('gambar', '!=', '')
                           ->offset($randomOffset)
                           ->limit($limit)
                           ->get(['id', 'judul', 'tanggal_publikasi', 'gambar', 'slug']);

        return view('berita::widget.random-news', compact('randomNews'))->render();
    }

    /**
     * Fungsi untuk mendapatkan data berita acak yang memiliki gambar (API untuk widget)
     */
    public function getRandomNewsData($limit = 1)
    {
        $totalWithImages = Berita::where('aktif', true)
                                  ->whereNotNull('gambar')
                                  ->where('gambar', '!=', '')
                                  ->count();

        if ($totalWithImages == 0) {
            return response()->json(collect([]));
        }

        $randomOffset = rand(0, max(0, $totalWithImages - 1));
        
        $randomNews = Berita::where('aktif', true)
                           ->whereNotNull('gambar')
                           ->where('gambar', '!=', '')
                           ->offset($randomOffset)
                           ->limit($limit)
                           ->get(['id', 'judul', 'tanggal_publikasi', 'gambar', 'slug']);

        return response()->json($randomNews);
    }

    /**
     * Fungsi untuk mendapatkan widget slider berita yang memiliki gambar
     */
    public function getSliderNewsWidget($limit = 5)
    {
        // Ambil berita aktif yang memiliki gambar secara acak
        $beritaWithImages = Berita::where('aktif', true)
                                  ->whereNotNull('gambar')
                                  ->where('gambar', '!=', '')
                                  ->select(['id', 'judul', 'tanggal_publikasi', 'gambar', 'slug'])
                                  ->get();
        
        if ($beritaWithImages->count() == 0) {
            // Jika tidak ada berita dengan gambar, kembalikan template kosong
            return view('berita::widget.slider-news', ['sliderNews' => collect([])])->render();
        }
        
        // Ambil berita secara acak sesuai limit
        $randomNews = $beritaWithImages->shuffle()->take($limit);
        
        return view('berita::widget.slider-news', compact('randomNews'))->render();
    }

    /**
     * Fungsi untuk mendapatkan data slider berita (API untuk widget)
     */
    public function getSliderNewsData($limit = 5)
    {
        $beritaWithImages = Berita::where('aktif', true)
                                  ->whereNotNull('gambar')
                                  ->where('gambar', '!=', '')
                                  ->select(['id', 'judul', 'tanggal_publikasi', 'gambar', 'slug'])
                                  ->get();
        
        if ($beritaWithImages->count() == 0) {
            return response()->json(collect([]));
        }
        
        $randomNews = $beritaWithImages->shuffle()->take($limit);
        
        return response()->json($randomNews);
    }
}