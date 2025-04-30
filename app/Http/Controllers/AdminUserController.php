<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CompanyProfile;
use App\Models\SellerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = User::query();
        
        // Filtrer par type d'utilisateur si spécifié
        if ($request->has('user_type')) {
            $query->where('user_type', $request->user_type);
        }
        
        // Filtrer par statut vendeur si spécifié
        if ($request->has('is_seller')) {
            $query->where('is_seller', $request->is_seller == 'yes');
        }
        
        $users = $query->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'user_type' => 'required|in:particulier,entreprise',
            'is_admin' => 'boolean',
            'is_seller' => 'boolean',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
            'is_admin' => $request->has('is_admin'),
            'is_seller' => $request->has('is_seller') && $request->user_type === 'particulier',
        ]);
        
        // Créer un profil d'entreprise vide si c'est une entreprise
        if ($request->user_type === 'entreprise') {
            CompanyProfile::create([
                'user_id' => $user->id,
                'profile_completed' => false,
            ]);
        }
        
        // Créer un profil vendeur vide si c'est un particulier vendeur
        if ($request->user_type === 'particulier' && $request->has('is_seller')) {
            SellerProfile::create([
                'user_id' => $user->id,
                'profile_completed' => false,
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'user_type' => 'required|in:particulier,entreprise',
            'is_admin' => 'boolean',
            'is_seller' => 'boolean',
        ]);

        $oldUserType = $user->user_type;
        $oldIsSeller = $user->is_seller;

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => $request->user_type,
            'is_admin' => $request->has('is_admin'),
            'is_seller' => $request->has('is_seller') && $request->user_type === 'particulier',
        ];

        // Mettre à jour le mot de passe uniquement s'il est fourni
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // Gérer les changements de type d'utilisateur
        if ($oldUserType !== $request->user_type) {
            // Si l'utilisateur devient une entreprise et n'a pas encore de profil d'entreprise
            if ($request->user_type === 'entreprise' && !$user->companyProfile) {
                CompanyProfile::create([
                    'user_id' => $user->id,
                    'profile_completed' => false,
                ]);
            }
            
            // Si l'utilisateur devient un particulier et était une entreprise, supprimer son profil d'entreprise
            if ($request->user_type === 'particulier' && $oldUserType === 'entreprise' && $user->companyProfile) {
                $user->companyProfile->delete();
            }
        }
        
        // Gérer les changements de statut vendeur pour les particuliers
        if ($request->user_type === 'particulier') {
            $isSeller = $request->has('is_seller');
            
            // Si l'utilisateur devient vendeur et n'a pas encore de profil vendeur
            if ($isSeller && !$oldIsSeller && !$user->sellerProfile) {
                SellerProfile::create([
                    'user_id' => $user->id,
                    'profile_completed' => false,
                ]);
            }
            
            // Si l'utilisateur n'est plus vendeur mais avait un profil vendeur, supprimer son profil vendeur
            if (!$isSeller && $oldIsSeller && $user->sellerProfile) {
                $user->sellerProfile->delete();
            }
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès');
    }
}
