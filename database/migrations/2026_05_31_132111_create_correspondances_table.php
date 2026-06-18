<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('correspondances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('annonce_id')->constrained()->onDelete('cascade');
            $table->foreignId('temoignage_id')->constrained()->onDelete('cascade');
            $table->decimal('score_similarite', 5, 2);
            $table->enum('statut', ['en_attente', 'confirme', 'infirme'])->default('en_attente');
            $table->boolean('notification_envoyee')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('correspondances');
    }
};