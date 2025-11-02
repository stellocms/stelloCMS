<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create roles table if it doesn't exist
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->timestamps();
            });
        }
        
        // Update users table to add role_id if column doesn't exist
        if (!Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('role_id')->nullable();
                $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            });
        }
        
        // Create a table for plugin management if needed
        if (!Schema::hasTable('plugins')) {
            Schema::create('plugins', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->boolean('active')->default(false);
                $table->boolean('installed')->default(false);
                $table->json('metadata')->nullable();
                $table->timestamps();
            });
        }
        
        // Create a table for berita if using the sample plugin
        if (!Schema::hasTable('berita_desa')) {
            Schema::create('berita_desa', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->text('isi');
                $table->string('gambar')->nullable();
                $table->timestamp('tanggal_publikasi')->useCurrent();
                $table->boolean('aktif')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_desa');
        Schema::dropIfExists('plugins');
        
        if (Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['role_id']);
                $table->dropColumn('role_id');
            });
        }
        
        Schema::dropIfExists('roles');
    }
};