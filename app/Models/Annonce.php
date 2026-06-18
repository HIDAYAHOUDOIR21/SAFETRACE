<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    protected $fillable = [
        'user_id', 'nom_personne', 'prenom_personne', 'date_naissance',
        'sexe', 'taille', 'description_physique', 'signes_particuliers',
        'date_disparition', 'derniere_localisation', 'latitude', 'longitude',
        'statut', 'valide_admin'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function temoignages()
    {
        return $this->hasMany(Temoignage::class);
    }

    public function correspondances()
    {
        return $this->hasMany(Correspondance::class);
    }

    public function signalements()
    {
        return $this->hasMany(SignalementAbus::class);
    }
}