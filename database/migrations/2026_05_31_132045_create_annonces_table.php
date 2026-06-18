<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('annonces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nom_personne');
            $table->string('prenom_personne');
            $table->date('date_naissance')->nullable();
            $table->enum('sexe', ['homme', 'femme', 'inconnu']);
            $table->decimal('taille', 5, 2)->nullable();
            $table->text('description_physique');
            $table->text('signes_particuliers')->nullable();
            $table->date('date_disparition');
            $table->string('derniere_localisation');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->enum('statut', ['en_cours', 'retrouve_vivant', 'retrouve_decede', 'archive'])->default('en_cours');
            $table->boolean('valide_admin')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('annonces');
    }
};