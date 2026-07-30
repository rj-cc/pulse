<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portal_section_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portal_section_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->longText('body')->nullable();
            $table->string('image_path')->nullable();
            $table->string('icon')->nullable();
            $table->string('url')->nullable();
            $table->json('badges')->nullable();
            $table->string('tag_label')->nullable();
            $table->string('tag_style')->nullable();
            $table->string('meta_text')->nullable();
            $table->string('accent_color')->nullable();
            $table->string('avatar_text')->nullable();
            $table->boolean('opens_modal')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['portal_section_id', 'is_published', 'sort_order'], 'psi_section_published_sort_idx');
            $table->index(['starts_at', 'ends_at'], 'psi_schedule_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portal_section_items');
    }
};
