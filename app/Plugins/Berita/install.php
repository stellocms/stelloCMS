<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

/**
 * Instalasi dan pembaruan tabel berita untuk plugin Berita
 * File ini digunakan untuk membuat atau memperbarui struktur tabel berita
 * ketika plugin Berita diinstal atau diperbarui
 */
class BeritaInstaller
{
    /**
     * Membuat atau memperbarui tabel berita
     */
    public static function install()
    {
        if (!Schema::hasTable('berita')) {
            // Buat tabel berita baru
            Schema::create('berita', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->text('isi');
                $table->string('gambar')->nullable();
                $table->timestamp('tanggal_publikasi')->useCurrent();
                $table->boolean('aktif')->default(true);
                $table->unsignedBigInteger('user_id')->nullable();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            });
        } else {
            // Lakukan pembaruan struktur tabel jika sudah ada
            static::updateTableStructure();
        }
        
        // Setelah instalasi selesai, coba buat widget
        static::createLatestNewsWidget();
        static::createPopularNewsWidget();
        static::createRandomNewsWidget();
    }

    /**
     * Memperbarui struktur tabel berita jika sudah ada
     */
    private static function updateTableStructure()
    {
        $columns = [
            'judul' => 'string',
            'isi' => 'text',
            'gambar' => 'string',
            'tanggal_publikasi' => 'timestamp',
            'aktif' => 'boolean',
            'user_id' => 'unsignedBigInteger',
            'meta_description' => 'string',
            'meta_keywords' => 'string',
            'slug' => 'string',
            'viewer' => 'integer',
            'kategori_id' => 'unsignedBigInteger'
        ];

        foreach ($columns as $columnName => $columnType) {
            if (!Schema::hasColumn('berita', $columnName)) {
                Schema::table('berita', function (Blueprint $table) use ($columnName, $columnType) {
                    switch ($columnType) {
                        case 'string':
                            if ($columnName === 'slug') {
                                $table->string($columnName)->unique()->nullable();
                            } else {
                                $table->string($columnName)->nullable();
                            }
                            break;
                        case 'text':
                            $table->text($columnName);
                            break;
                        case 'timestamp':
                            $table->timestamp($columnName)->useCurrent();
                            break;
                        case 'boolean':
                            $table->boolean($columnName)->default(true);
                            break;
                        case 'unsignedBigInteger':
                            $table->unsignedBigInteger($columnName)->nullable();
                            break;
                        case 'integer':
                            $table->integer($columnName)->default(0);
                            break;
                    }
                });
            }
        }

        // Tambahkan foreign key untuk user_id jika belum ada
        if (Schema::hasColumn('berita', 'user_id') && 
            !static::hasForeignKey('berita', 'berita_user_id_foreign')) {
            Schema::table('berita', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            });
        }

        // Tambahkan foreign key untuk kategori_id jika belum ada dan plugin Kategori terinstal
        if (Schema::hasColumn('berita', 'kategori_id') &&
            !static::hasForeignKey('berita', 'berita_kategori_id_foreign') &&
            Schema::hasTable('kategori_berita')) {
            Schema::table('berita', function (Blueprint $table) {
                $table->foreign('kategori_id')->references('id')->on('kategori_berita')->onDelete('set null');
            });
        }

        // Pastikan kolom slug unik jika belum diatur
        if (Schema::hasColumn('berita', 'slug') && !static::isUnique('berita', 'slug')) {
            // Membuat slug unik untuk record yang sudah ada
            static::ensureUniqueSlugs();
        }

        // Perbarui tipe data kolom jika perlu
        static::updateColumnTypes();
    }

    /**
     * Periksa apakah foreign key sudah ada
     */
    private static function hasForeignKey($table, $keyName)
    {
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = ? 
            AND CONSTRAINT_NAME = ?
        ", [$table, $keyName]);

        return count($foreignKeys) > 0;
    }

    /**
     * Periksa apakah kolom memiliki indeks unik
     */
    private static function isUnique($table, $column)
    {
        // Cek apakah kolom memiliki indeks unik
        $indexes = DB::select("
            SELECT 
                COLUMN_NAME,
                CONSTRAINT_NAME,
                REFERENCED_COLUMN_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME = ?
                AND COLUMN_NAME = ?
                AND CONSTRAINT_NAME != 'PRIMARY'
        ", [$table, $column]);

        foreach ($indexes as $index) {
            // Periksa apakah ini indeks unik
            $constraintInfo = DB::select("
                SELECT CONSTRAINT_NAME
                FROM information_schema.TABLE_CONSTRAINTS
                WHERE TABLE_SCHEMA = DATABASE()
                    AND TABLE_NAME = ?
                    AND CONSTRAINT_NAME = ?
                    AND CONSTRAINT_TYPE = 'UNIQUE'
            ", [$table, $index->CONSTRAINT_NAME]);

            if (!empty($constraintInfo)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Pastikan semua slug unik
     */
    private static function ensureUniqueSlugs()
    {
        $records = DB::table('berita')->get();

        foreach ($records as $record) {
            if (empty($record->judul)) {
                continue; // Lewati jika judul kosong
            }

            $originalSlug = generate_slug($record->judul);
            $counter = 1;
            $newSlug = $originalSlug;

            // Cek konflik slug
            while (DB::table('berita')
                    ->where('slug', $newSlug)
                    ->where('id', '!=', $record->id)
                    ->exists()) {
                $newSlug = $originalSlug . '-' . $counter;
                $counter++;
            }

            if ($newSlug !== $record->slug) {
                DB::table('berita')
                    ->where('id', $record->id)
                    ->update(['slug' => $newSlug]);
            }
        }
    }

    /**
     * Perbarui tipe data kolom jika diperlukan
     */
    private static function updateColumnTypes()
    {
        // Pastikan kolom tanggal_publikasi menggunakan CURRENT_TIMESTAMP sebagai default
        try {
            DB::statement("ALTER TABLE berita MODIFY COLUMN tanggal_publikasi TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
        } catch (\Exception $e) {
            // Jika gagal, lewati (mungkin karena kolom sudah benar)
        }

        // Pastikan kolom aktif adalah boolean dengan default true
        try {
            DB::statement("ALTER TABLE berita MODIFY COLUMN aktif BOOLEAN DEFAULT TRUE");
        } catch (\Exception $e) {
            // Jika gagal, lewati
        }
    }

    /**
     * Membuat widget otomatis untuk berita terbaru
     */
    public static function createLatestNewsWidget()
    {
        // Cek apakah tabel widgets ada
        if (!Schema::hasTable('widgets')) {
            return;
        }

        // Cek apakah widget sudah ada
        $existingWidget = DB::table('widgets')->where('name', 'berita-terbaru-widget')->first();
        
        if (!$existingWidget) {
            // Tambahkan widget berita terbaru
            DB::table('widgets')->insert([
                'name' => 'berita-terbaru-widget',
                'type' => 'plugin',
                'position' => 'sidebar-right',  // Cocok untuk sidebar kanan
                'status' => 'aktif',
                'content' => null,
                'plugin_name' => 'Berita',  // Nama plugin harus sesuai
                'order' => 1,
                'settings' => json_encode([
                    'limit' => 5,
                    'show_date' => true,
                    'show_thumbnails' => false,
                    'title' => 'Berita Terbaru'
                ]),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Menghapus tabel berita (untuk uninstall)
     */
    public static function uninstall()
    {
        if (Schema::hasTable('berita')) {
            Schema::dropIfExists('berita');
        }
        
        // Hapus widget yang terkait dengan plugin berita jika diperlukan
        if (Schema::hasTable('widgets')) {
            DB::table('widgets')->where('plugin_name', 'Berita')->delete();
        }
    }
    
    /**
     * Membuat widget otomatis untuk berita populer
     */
    public static function createPopularNewsWidget()
    {
        // Cek apakah tabel widgets ada
        if (!Schema::hasTable('widgets')) {
            return;
        }

        // Cek apakah widget sudah ada
        $existingWidget = DB::table('widgets')->where('name', 'berita-populer-widget')->first();
        
        if (!$existingWidget) {
            // Tambahkan widget berita populer
            DB::table('widgets')->insert([
                'name' => 'berita-populer-widget',
                'type' => 'plugin',
                'position' => 'sidebar-right',  // Cocok untuk sidebar kanan
                'status' => 'aktif',
                'content' => null,
                'plugin_name' => 'Berita',  // Nama plugin harus sesuai
                'order' => 2,  // Berada setelah widget berita terbaru
                'settings' => json_encode([
                    'limit' => 5,
                    'show_views' => true,
                    'show_date' => false,
                    'title' => 'Berita Populer'
                ]),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
    
    /**
     * Membuat widget otomatis untuk berita acak yang memiliki gambar
     */
    public static function createRandomNewsWidget()
    {
        // Cek apakah tabel widgets ada
        if (!Schema::hasTable('widgets')) {
            return;
        }

        // Cek apakah widget sudah ada
        $existingWidget = DB::table('widgets')->where('name', 'berita-acak-widget')->first();
        
        if (!$existingWidget) {
            // Tambahkan widget berita acak
            DB::table('widgets')->insert([
                'name' => 'berita-acak-widget',
                'type' => 'plugin',
                'position' => 'sidebar-left',  // Cocok untuk sidebar kiri
                'status' => 'aktif',
                'content' => null,
                'plugin_name' => 'Berita',  // Nama plugin harus sesuai
                'order' => 3,  // Berada setelah widget berita terbaru dan populer
                'settings' => json_encode([
                    'limit' => 1,
                    'has_image' => true,
                    'random' => true,
                    'title' => 'Berita Acak'
                ]),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}

// Panggil metode install saat file ini di-include
BeritaInstaller::install();