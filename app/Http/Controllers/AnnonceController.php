<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Photo;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnnonceController extends Controller
{
    public function index(Request $request)
    {
        $query = Annonce::where('statut', 'en_cours');

        if($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nom_personne', 'like', '%'.$request->search.'%')
                  ->orWhere('prenom_personne', 'like', '%'.$request->search.'%');
            });
        }

        if($request->region) {
            $query->where('derniere_localisation', 'like', '%'.$request->region.'%');
        }

        if($request->sexe) {
            $query->where('sexe', $request->sexe);
        }

        $annonces = $query->latest()->get();
        return view('annonces', compact('annonces'));
    }

    public function create()
    {
        return view('create_annonce');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_personne' => 'required|string|max:100',
            'prenom_personne' => 'required|string|max:100',
            'sexe' => 'required|in:homme,femme,inconnu',
            'description_physique' => 'required|string',
            'date_disparition' => 'required|date',
            'derniere_localisation' => 'required|string',
        ]);

        $annonce = Annonce::create([
            'user_id' => Auth::id(),
            'nom_personne' => $request->nom_personne,
            'prenom_personne' => $request->prenom_personne,
            'date_naissance' => $request->date_naissance,
            'sexe' => $request->sexe,
            'taille' => $request->taille,
            'description_physique' => $request->description_physique,
            'signes_particuliers' => $request->signes_particuliers,
            'date_disparition' => $request->date_disparition,
            'derniere_localisation' => $request->derniere_localisation,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'statut' => 'en_cours',
            'valide_admin' => false,
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            Photo::create([
                'annonce_id' => $annonce->id,
                'url_photo' => $path,
                'est_principale' => true,
            ]);
        }

        return redirect('/annonces')->with('success', 'Annonce publiée avec succès !');
    }

    public function show($id)
    {
        $annonce = Annonce::with('photos', 'temoignages', 'correspondances.temoignage')->findOrFail($id);
        return view('annonce_detail', compact('annonce'));
    }

    public function edit($id)
    {
        $annonce = Annonce::findOrFail($id);
        if(Auth::id() != $annonce->user_id) {
            return redirect('/annonces');
        }
        return view('edit_annonce', compact('annonce'));
    }

    public function update(Request $request, $id)
    {
        $annonce = Annonce::findOrFail($id);
        if(Auth::id() != $annonce->user_id) {
            return redirect('/annonces');
        }
        $annonce->update([
            'nom_personne' => $request->nom_personne,
            'prenom_personne' => $request->prenom_personne,
            'date_naissance' => $request->date_naissance,
            'sexe' => $request->sexe,
            'taille' => $request->taille,
            'description_physique' => $request->description_physique,
            'signes_particuliers' => $request->signes_particuliers,
            'date_disparition' => $request->date_disparition,
            'derniere_localisation' => $request->derniere_localisation,
        ]);
        return redirect('/annonces/'.$id)->with('success', 'Annonce modifiée avec succès !');
    }

    public function destroy($id)
    {
        $annonce = Annonce::findOrFail($id);
        if(Auth::id() != $annonce->user_id) {
            return redirect('/annonces');
        }
        $annonce->delete();
        return redirect('/annonces')->with('success', 'Annonce supprimée avec succès !');
    }

    public function carte()
    {
        $annonces = Annonce::where('statut', 'en_cours')->get();
        return view('carte', compact('annonces'));
    }

    public function dashboard()
    {
        $mes_annonces = Annonce::where('user_id', Auth::id())->latest()->get();
        $notifications = Notification::where('user_id', Auth::id())
                                     ->where('lu', false)
                                     ->latest()
                                     ->get();
        return view('dashboard_user', compact('mes_annonces', 'notifications'));
    }

    public function marquerRetrouve($id)
    {
        $annonce = Annonce::findOrFail($id);
        if(Auth::id() != $annonce->user_id) {
            return redirect('/annonces');
        }
        $annonce->update(['statut' => 'retrouve_vivant']);
        return redirect('/annonces/'.$id)->with('success', 'Annonce marquée comme retrouvée !');
    }

    public function marquerNotificationsLues()
    {
        Notification::where('user_id', Auth::id())->update(['lu' => true]);
        return redirect('/mes-annonces')->with('success', 'Notifications marquées comme lues !');
    }
}