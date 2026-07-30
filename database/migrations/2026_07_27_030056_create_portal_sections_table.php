<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portal_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('layout');
            $table->string('view_all_label')->nullable();
            $table->unsignedInteger('initial_items_count')->nullable();
            $table->string('collapse_label')->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['is_published', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portal_sections');
    }
};
