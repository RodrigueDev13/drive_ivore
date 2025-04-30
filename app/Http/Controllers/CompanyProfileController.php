<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyProfileController extends Controller
{
    /**
     * Affiche le formulaire de profil d'entreprise.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = auth()->user();
        
        // Vérifier si l'utilisateur est une entreprise
        if ($user->user_type !== 'entreprise') {
            return redirect()->route('home')->with('error', 'Cette page est réservée aux comptes entreprise.');
        }
        
        // Récupérer ou créer le profil d'entreprise
        $companyProfile = $user->companyProfile ?? new \App\Models\CompanyProfile(['user_id' => $user->id]);
        
        return view('profile.company', compact('companyProfile'));
    }
    
    /**
     * Met à jour le profil d'entreprise.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        
        // Vérifier si l'utilisateur est une entreprise
        if ($user->user_type !== 'entreprise') {
            return redirect()->route('home')->with('error', 'Cette action est réservée aux comptes entreprise.');
        }
        
        // Valider les données
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'registration_number' => 'nullable|string|max:50',
            'tax_id' => 'nullable|string|max:50',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'phone_number' => 'required|string|max:20',
            'description' => 'nullable|string|max:1000',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Gérer le téléchargement du logo si présent
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('company_logos', 'public');
            $validated['logo'] = $logoPath;
        }
        
        // Mettre à jour ou créer le profil d'entreprise
        $companyProfile = $user->companyProfile ?? new \App\Models\CompanyProfile(['user_id' => $user->id]);
        $companyProfile->fill($validated);
        
        // Mettre à jour le statut de complétion
        $companyProfile->updateCompletionStatus();
        
        // Sauvegarder le profil
        if (!$companyProfile->exists) {
            $user->companyProfile()->save($companyProfile);
        } else {
            $companyProfile->save();
        }
        
        return redirect()->route('profile.company.edit')
            ->with('success', 'Profil d\'entreprise mis à jour avec succès.');
    }
    
    /**
     * Vérifie si le profil d'entreprise est complet avant de créer un véhicule.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkProfileBeforeVehicleCreation(Request $request)
    {
        $user = auth()->user();
        
        if ($user->user_type === 'entreprise' && !$user->hasCompletedCompanyProfile()) {
            return response()->json([
                'can_create' => false,
                'redirect_url' => route('profile.company.edit'),
                'message' => 'Vous devez compléter votre profil d\'entreprise avant de pouvoir créer une annonce.'
            ]);
        }
        
        return response()->json(['can_create' => true]);
    }
}
