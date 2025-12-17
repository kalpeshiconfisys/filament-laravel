<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('blogs', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('excerpt');
        $table->longText('description');
        $table->string('thumbnail')->nullable();
        $table->string('featured_image')->nullable();
        $table->string('meta_title')->nullable();
        $table->string('meta_description')->nullable();
        $table->timestamp('published_at')->nullable();
        $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
        $table->boolean('is_featured')->default(false);
        $table->unsignedInteger('view_count')->default(0);
        $table->unsignedInteger('reading_time')->nullable();
        $table->string('video_url')->nullable();
        $table->string('location')->nullable();
        $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
