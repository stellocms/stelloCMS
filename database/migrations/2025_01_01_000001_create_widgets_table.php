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
        Schema::create('widgets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['plugin', 'text', 'html']);
            $table->enum('position', ['header', 'sidebar-left', 'sidebar-right', 'footer', 'home']);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->text('content')->nullable();
            $table->string('plugin_name')->nullable();
            $table->integer('order')->default(0);
            $table->json('settings')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('widgets');
    }
};