<?php

namespace App\Helpers;

use App\Models\Notification;

class NotificationHelper
{
    public static function envoyer($userId, $titre, $message)
    {
        return Notification::create([
            'user_id' => $userId,
            'titre' => $titre,
            'message' => $message,
            'lu' => false
        ]);
    }

    public static function envoyerGroupe($userIds, $titre, $message)
    {
        $notifications = [];
        foreach ($userIds as $userId) {
            $notifications[] = [
                'user_id' => $userId,
                'titre' => $titre,
                'message' => $message,
                'lu' => false,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        return Notification::insert($notifications);
    }

    public static function compterNonLues($userId)
    {
        return Notification::where('user_id', $userId)
            ->where('lu', false)
            ->count();
    }
}