<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerProfileController extends Controller
{
    /**
     * Affiche le formulaire de profil vendeur.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = auth()->user();
        
        // Vérifier si l'utilisateur est un particulier vendeur
        if ($user->user_type !== 'particulier' || !$user->is_seller) {
            return redirect()->route('home')->with('error', 'Cette page est réservée aux vendeurs particuliers.');
        }
        
        // Récupérer ou créer le profil vendeur
        $sellerProfile = $user->sellerProfile ?? new \App\Models\SellerProfile(['user_id' => $user->id]);
        
        return view('profile.seller', compact('sellerProfile'));
    }
    
    /**
     * Met à jour le profil vendeur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        
        // Vérifier si l'utilisateur est un particulier vendeur
        if ($user->user_type !== 'particulier' || !$user->is_seller) {
            return redirect()->route('home')->with('error', 'Cette action est réservée aux vendeurs particuliers.');
        }
        
        // Valider les données
        $validated = $request->validate([
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'identity_document' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);
        
        // Gérer le téléchargement du document d'identité si présent
        if ($request->hasFile('identity_document')) {
            $documentPath = $request->file('identity_document')->store('identity_documents', 'public');
            $validated['identity_document'] = $documentPath;
        }
        
        // Mettre à jour ou créer le profil vendeur
        $sellerProfile = $user->sellerProfile ?? new \App\Models\SellerProfile(['user_id' => $user->id]);
        $sellerProfile->fill($validated);
        
        // Mettre à jour le statut de complétion
        $sellerProfile->updateCompletionStatus();
        
        // Sauvegarder le profil
        if (!$sellerProfile->exists) {
            $user->sellerProfile()->save($sellerProfile);
        } else {
            $sellerProfile->save();
        }
        
        return redirect()->route('profile.seller.edit')
            ->with('success', 'Profil vendeur mis à jour avec succès.');
    }
    
    /**
     * Vérifie si le profil vendeur est complet avant de créer un véhicule.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkProfileBeforeVehicleCreation(Request $request)
    {
        $user = auth()->user();
        
        if ($user->user_type === 'particulier' && $user->is_seller && !$user->hasCompletedSellerProfile()) {
            return response()->json([
                'can_create' => false,
                'redirect_url' => route('profile.seller.edit'),
                'message' => 'Vous devez compléter votre profil vendeur avant de pouvoir créer une annonce.'
            ]);
        }
        
        return response()->json(['can_create' => true]);
    }
}
