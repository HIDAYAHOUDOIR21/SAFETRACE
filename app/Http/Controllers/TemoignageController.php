<?php

namespace App\Http\Controllers;

use App\Models\Temoignage;
use App\Models\Annonce;
use App\Models\Correspondance;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemoignageController extends Controller
{
    public function create($annonce_id)
    {
        $annonce = Annonce::findOrFail($annonce_id);
        return view('create_temoignage', compact('annonce'));
    }

    public function store(Request $request, $annonce_id)
    {
        $request->validate([
            'contenu' => 'required|string',
            'localisation_vue' => 'required|string',
            'date_observation' => 'required|date',
        ]);

        $temoignage = Temoignage::create([
            'annonce_id' => $annonce_id,
            'user_id' => Auth::id() ?? null,
            'contenu' => $request->contenu,
            'localisation_vue' => $request->localisation_vue,
            'date_observation' => $request->date_observation,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'valide' => true,
        ]);

        $annonce = Annonce::findOrFail($annonce_id);

        // Notification au propriétaire
        Notification::create([
            'user_id' => $annonce->user_id,
            'type' => 'temoignage',
            'message' => 'Un nouveau témoignage a été soumis pour votre annonce : ' . $annonce->prenom_personne . ' ' . $annonce->nom_personne,
            'lu' => false,
        ]);

        $score = $this->calculerMatching($annonce_id, $temoignage);

        // Notification si correspondance détectée
        if($score >= 30) {
            Notification::create([
                'user_id' => $annonce->user_id,
                'type' => 'correspondance',
                'message' => 'Une correspondance a été détectée pour votre annonce : ' . $annonce->prenom_personne . ' ' . $annonce->nom_personne . ' (Score: ' . $score . '/100)',
                'lu' => false,
            ]);
        }

        return redirect('/annonces/'.$annonce_id)->with('success', 'Témoignage soumis avec succès !');
    }

    private function calculerMatching($annonce_id, $temoignage)
    {
        $annonce = Annonce::findOrFail($annonce_id);
        $score = 0;

        if($temoignage->localisation_vue && $annonce->derniere_localisation) {
            similar_text(
                strtolower($temoignage->localisation_vue),
                strtolower($annonce->derniere_localisation),
                $percent
            );
            if($percent > 50) $score += 30;
            elseif($percent > 30) $score += 15;
        }

        if($temoignage->contenu && $annonce->description_physique) {
            similar_text(
                strtolower($temoignage->contenu),
                strtolower($annonce->description_physique),
                $percent
            );
            if($percent > 30) $score += 40;
            elseif($percent > 15) $score += 20;
        }

        if($temoignage->date_observation && $annonce->date_disparition) {
            $diff = abs(strtotime($temoignage->date_observation) - strtotime($annonce->date_disparition));
            $days = $diff / (60 * 60 * 24);
            if($days <= 7) $score += 30;
            elseif($days <= 30) $score += 15;
        }

        if($score >= 30) {
            Correspondance::create([
                'annonce_id' => $annonce_id,
                'temoignage_id' => $temoignage->id,
                'score_similarite' => $score,
                'statut' => 'en_attente',
                'notification_envoyee' => true,
            ]);
        }

        return $score;
    }

    public function destroy($annonce_id, $temoignage_id)
    {
        $temoignage = Temoignage::findOrFail($temoignage_id);
        $temoignage->delete();
        return redirect('/annonces/'.$annonce_id)->with('success', 'Témoignage supprimé !');
    }
}