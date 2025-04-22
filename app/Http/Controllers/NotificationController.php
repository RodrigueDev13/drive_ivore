<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Afficher toutes les notifications de l'utilisateur.
     */
    public function index()
    {
        $notifications = Auth::user()->userNotifications()->latest()->paginate(15);
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Marquer une notification comme lue.
     */
    public function markAsRead(Notification $notification)
    {
        // Vérifier si l'utilisateur est le propriétaire de la notification
        if ($notification->user_id !== Auth::id()) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à modifier cette notification.');
        }

        $notification->markAsRead();

        return back()->with('success', 'Notification marquée comme lue.');
    }

    /**
     * Marquer toutes les notifications comme lues.
     */
    public function markAllAsRead()
    {
        Auth::user()->userNotifications()->whereNull('read_at')->update(['read_at' => now()]);

        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }

    /**
     * Supprimer une notification.
     */
    public function destroy(Notification $notification)
    {
        // Vérifier si l'utilisateur est le propriétaire de la notification
        if ($notification->user_id !== Auth::id()) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à supprimer cette notification.');
        }

        $notification->delete();

        return back()->with('success', 'Notification supprimée avec succès.');
    }

    /**
     * Supprimer toutes les notifications.
     */
    public function destroyAll()
    {
        Auth::user()->userNotifications()->delete();

        return back()->with('success', 'Toutes les notifications ont été supprimées.');
    }
}
