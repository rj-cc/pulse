<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portal_settings', function (Blueprint $table) {
            $table->id();
            $table->string('organization_name');
            $table->string('organization_tagline')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('topbar_phone')->nullable();
            $table->string('topbar_email')->nullable();
            $table->string('topbar_right_label')->nullable();
            $table->text('hero_subtitle')->nullable();
            $table->string('hero_motto')->nullable();
            $table->string('footer_motto')->nullable();
            $table->string('footer_copyright')->nullable();
            $table->string('footer_right_label')->nullable();
            $table->json('footer_links')->nullable();
            $table->string('color_palette')->default('navy_gold');
            $table->string('font_style')->default('manrope_fraunces');
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portal_settings');
    }
};
