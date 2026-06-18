<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $annonces_en_attente = Annonce::where('valide_admin', false)->latest()->get();
        $annonces_validees = Annonce::where('valide_admin', true)->latest()->get();
        $total_users = User::count();
        $total_annonces = Annonce::count();
        $total_retrouvees = Annonce::where('statut', 'retrouve_vivant')->count();
        
        return view('admin', compact(
            'annonces_en_attente',
            'annonces_validees',
            'total_users',
            'total_annonces',
            'total_retrouvees'
        ));
    }

    public function valider($id)
    {
        $annonce = Annonce::findOrFail($id);
        $annonce->update(['valide_admin' => true]);
        return redirect('/admin')->with('success', 'Annonce validée !');
    }

    public function refuser($id)
    {
        $annonce = Annonce::findOrFail($id);
        $annonce->delete();
        return redirect('/admin')->with('success', 'Annonce supprimée !');
    }
}