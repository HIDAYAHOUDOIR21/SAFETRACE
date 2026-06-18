<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Correspondance extends Model
{
    protected $fillable = [
        'annonce_id', 'temoignage_id', 'score_similarite',
        'statut', 'notification_envoyee'
    ];

    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }

    public function temoignage()
    {
        return $this->belongsTo(Temoignage::class);
    }
}