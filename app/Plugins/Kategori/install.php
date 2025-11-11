<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

/**
 * Instalasi dan pembaruan tabel kategori_berita untuk plugin Kategori
 * File ini digunakan untuk membuat atau memperbarui struktur tabel kategori_berita
 * ketika plugin Kategori diinstal atau diperbarui
 */
class KategoriInstaller
{
    /**
     * Membuat atau memperbarui tabel kategori_berita
     */
    public static function install()
    {
        if (!Schema::hasTable('kategori_berita')) {
            // Buat tabel kategori_berita baru
            Schema::create('kategori_berita', function (Blueprint $table) {
                $table->id();
                $table->string('nama_kategori');
                $table->text('deskripsi')->nullable();
                $table->string('warna')->default('#007bff');  // warna hex untuk tampilan UI
                $table->string('ikon')->default('fas fa-tag');  // ikon font awesome
                $table->boolean('aktif')->default(true);
                $table->timestamps();
            });
        } else {
            // Lakukan pembaruan struktur tabel jika sudah ada
            static::updateTableStructure();
        }
    }

    /**
     * Memperbarui struktur tabel kategori_berita jika sudah ada
     */
    private static function updateTableStructure()
    {
        $columns = [
            'nama_kategori' => 'string',
            'deskripsi' => 'text',
            'warna' => 'string',
            'ikon' => 'string',
            'aktif' => 'boolean'
        ];

        foreach ($columns as $columnName => $columnType) {
            if (!Schema::hasColumn('kategori_berita', $columnName)) {
                Schema::table('kategori_berita', function (Blueprint $table) use ($columnName, $columnType) {
                    switch ($columnType) {
                        case 'string':
                            if ($columnName == 'aktif') {
                                $table->string($columnName)->default('#007bff');
                            } elseif ($columnName == 'ikon') {
                                $table->string($columnName)->default('fas fa-tag');
                            } else {
                                $table->string($columnName);
                            }
                            break;
                        case 'text':
                            $table->text($columnName)->nullable();
                            break;
                        case 'boolean':
                            $table->boolean($columnName)->default(true);
                            break;
                    }
                });
            }
        }
        
        // Pastikan kolom warna dan ikon memiliki default values jika belum ada
        if (Schema::hasColumn('kategori_berita', 'warna') && 
            !Schema::hasColumn('kategori_berita', 'warna_default_set')) {
            try {
                DB::statement("ALTER TABLE kategori_berita ALTER COLUMN warna SET DEFAULT '#007bff'");
            } catch (\Exception $e) {
                // Jika terjadi error, abaikan karena mungkin sudah memiliki default
            }
        }
        
        if (Schema::hasColumn('kategori_berita', 'ikon') && 
            !Schema::hasColumn('kategori_berita', 'ikon_default_set')) {
            try {
                DB::statement("ALTER TABLE kategori_berita ALTER COLUMN ikon SET DEFAULT 'fas fa-tag'");
            } catch (\Exception $e) {
                // Jika terjadi error, abaikan karena mungkin sudah memiliki default
            }
        }
    }

    /**
     * Menghapus tabel kategori_berita (untuk uninstall)
     */
    public static function uninstall()
    {
        if (Schema::hasTable('kategori_berita')) {
            Schema::dropIfExists('kategori_berita');
        }
    }
}

// Panggil metode install saat file ini di-include
KategoriInstaller::install();