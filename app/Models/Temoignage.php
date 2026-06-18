<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Temoignage extends Model
{
    protected $fillable = [
        'annonce_id', 'user_id', 'contenu', 'localisation_vue',
        'date_observation', 'latitude', 'longitude', 'valide'
    ];

    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function correspondances()
    {
        return $this->hasMany(Correspondance::class);
    }
}