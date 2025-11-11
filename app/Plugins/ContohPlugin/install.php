<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

/**
 * Instalasi dan pembaruan tabel contoh_plugin untuk plugin ContohPlugin
 * File ini digunakan untuk membuat atau memperbarui struktur tabel contoh_plugins
 * ketika plugin ContohPlugin diinstal atau diperbarui
 */
class ContohPluginInstaller
{
    /**
     * Membuat atau memperbarui tabel contoh_plugins
     */
    public static function install()
    {
        if (!Schema::hasTable('contoh_plugins')) {
            // Buat tabel contoh_plugins baru
            Schema::create('contoh_plugins', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->text('deskripsi');
                $table->string('gambar')->nullable();
                $table->timestamp('tanggal_dibuat')->nullable();
                $table->boolean('aktif')->default(true);
                $table->string('slug')->unique();
                $table->timestamps();
            });
        } else {
            // Lakukan pembaruan struktur tabel jika sudah ada
            static::updateTableStructure();
        }
    }

    /**
     * Memperbarui struktur tabel contoh_plugins jika sudah ada
     */
    private static function updateTableStructure()
    {
        $columns = [
            'judul' => 'string',
            'deskripsi' => 'text',
            'gambar' => 'string',
            'tanggal_dibuat' => 'timestamp',
            'aktif' => 'boolean',
            'slug' => 'string'
        ];

        foreach ($columns as $columnName => $columnType) {
            if (!Schema::hasColumn('contoh_plugins', $columnName)) {
                Schema::table('contoh_plugins', function (Blueprint $table) use ($columnName, $columnType) {
                    switch ($columnType) {
                        case 'string':
                            if ($columnName === 'slug') {
                                $table->string($columnName)->unique();
                            } else {
                                $table->string($columnName)->nullable();
                            }
                            break;
                        case 'text':
                            $table->text($columnName);
                            break;
                        case 'timestamp':
                            $table->timestamp($columnName)->nullable();
                            break;
                        case 'boolean':
                            $table->boolean($columnName)->default(true);
                            break;
                    }
                });
            }
        }

        // Pastikan kolom slug unik jika belum diatur
        if (Schema::hasColumn('contoh_plugins', 'slug') && !static::isUnique('contoh_plugins', 'slug')) {
            // Membuat slug unik untuk record yang sudah ada
            static::ensureUniqueSlugs();
        }

        // Perbarui tipe data kolom jika perlu
        static::updateColumnTypes();
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
        $records = DB::table('contoh_plugins')->get();

        foreach ($records as $record) {
            $originalSlug = $record->slug;
            $counter = 1;
            $newSlug = $originalSlug;

            // Cek konflik slug
            while (DB::table('contoh_plugins')
                    ->where('slug', $newSlug)
                    ->where('id', '!=', $record->id)
                    ->exists()) {
                $newSlug = $originalSlug . '-' . $counter;
                $counter++;
            }

            if ($newSlug !== $originalSlug) {
                DB::table('contoh_plugins')
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
        // Pastikan kolom tanggal_dibuat adalah timestamp nullable
        try {
            DB::statement("ALTER TABLE contoh_plugins MODIFY COLUMN tanggal_dibuat TIMESTAMP NULL");
        } catch (\Exception $e) {
            // Jika gagal, lewati (mungkin karena kolom sudah benar)
        }

        // Pastikan kolom aktif adalah boolean dengan default true
        try {
            DB::statement("ALTER TABLE contoh_plugins MODIFY COLUMN aktif BOOLEAN DEFAULT TRUE");
        } catch (\Exception $e) {
            // Jika gagal, lewati
        }

        // Tambahkan indeks unik ke kolom slug jika belum ada
        try {
            $hasUniqueIndex = DB::select("
                SELECT CONSTRAINT_NAME
                FROM information_schema.TABLE_CONSTRAINTS
                WHERE TABLE_SCHEMA = DATABASE()
                    AND TABLE_NAME = 'contoh_plugins'
                    AND COLUMN_NAME = 'slug'
                    AND CONSTRAINT_TYPE = 'UNIQUE'
            ");

            if (empty($hasUniqueIndex)) {
                DB::statement("ALTER TABLE contoh_plugins ADD UNIQUE INDEX unique_slug (slug)");
            }
        } catch (\Exception $e) {
            // Jika indeks sudah ada, lewati
        }
    }

    /**
     * Menghapus tabel contoh_plugins (untuk uninstall)
     */
    public static function uninstall()
    {
        if (Schema::hasTable('contoh_plugins')) {
            Schema::dropIfExists('contoh_plugins');
        }
    }
}

// Panggil metode install saat file ini di-include
ContohPluginInstaller::install();