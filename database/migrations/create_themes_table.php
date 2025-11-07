<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // 'frontend' or 'admin'
            $table->string('version')->nullable();
            $table->text('description')->nullable();
            $table->string('author')->nullable();
            $table->string('author_url')->nullable();
            $table->string('screenshot')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_installed')->default(false);
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            
            // Ensure only one default theme per type
            $table->unique(['type', 'is_default'], 'unique_default_theme_per_type');
        });
        
        // Insert default Stocker theme
        DB::table('themes')->insert([
            'name' => 'stocker',
            'type' => 'frontend',
            'version' => '1.0.0',
            'description' => 'Stocker - Stock Market Website Template',
            'author' => 'HTML Codex',
            'author_url' => 'https://htmlcodex.com',
            'screenshot' => 'img/carousel-1.jpg',
            'tags' => json_encode(['stock-market', 'finance', 'investment', 'business', 'responsive']),
            'is_active' => true,
            'is_installed' => true,
            'is_default' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};