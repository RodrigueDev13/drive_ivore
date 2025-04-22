<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Afficher tous les avis de l'utilisateur.
     */
    public function index()
    {
        $reviews = Auth::user()->reviews()->with('vehicle.brand')->latest()->get();
        return view('reviews.index', compact('reviews'));
    }

    /**
     * Enregistrer un nouvel avis.
     */
    public function store(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Vérifier si l'utilisateur a déjà laissé un avis pour ce véhicule
        $existingReview = Review::where('user_id', Auth::id())
            ->where('vehicle_id', $vehicle->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Vous avez déjà laissé un avis pour ce véhicule.');
        }

        // Créer l'avis
        Review::create([
            'user_id' => Auth::id(),
            'vehicle_id' => $vehicle->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Votre avis a été publié avec succès.');
    }

    /**
     * Mettre à jour un avis.
     */
    public function update(Request $request, Review $review)
    {
        // Vérifier si l'utilisateur est le propriétaire de l'avis
        if ($review->user_id !== Auth::id()) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à modifier cet avis.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Votre avis a été mis à jour avec succès.');
    }

    /**
     * Supprimer un avis.
     */
    public function destroy(Review $review)
    {
        // Vérifier si l'utilisateur est le propriétaire de l'avis
        if ($review->user_id !== Auth::id()) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à supprimer cet avis.');
        }

        $review->delete();

        return back()->with('success', 'Votre avis a été supprimé avec succès.');
    }
}
