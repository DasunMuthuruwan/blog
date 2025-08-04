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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('content'); // HTML or image URL
            $table->enum('type', ['corner', 'banner', 'popup'])->default('corner')->index();
            $table->timestamp('start_at')->nullable()->index();
            $table->timestamp('end_at')->nullable();
            $table->boolean('is_default')->default(false); // use as fallback
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
