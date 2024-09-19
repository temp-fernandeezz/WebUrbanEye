<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    public function getUserNotifications()
    {
        // Verifica se o usuário está autenticado
        if (!Auth::check()) {
            return response()->json(['error' => 'Usuário não autenticado'], 401);
        }

        // Pega o ID do usuário autenticado
        $userId = Auth::id();

        // Filtra as notificações de acordo com o tipo e os status "pending" ou "approved"
        $notifications = Report::where('user_id', $userId)
            ->where(function ($query) {
                $query->where('status', 'pending')
                    ->orWhere('status', 'approved');
            })
            ->where(function ($query) {
                $query->where('type', 'robberies')
                    ->orWhereNull('user_id');
            })
            ->get();

        return response()->json($notifications);
    }


    public function confirmNotification(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Usuário não autenticado'], 401);
        }

        $report = Report::findOrFail($id);
        $report->update(['status' => 'approved']);

        // Cria uma nova notificação
        Notification::create([
            'id' => $id,
            'user_id' => Auth::id(),
            'title' => 'Nova confirmação de denúncia',
            'message' => 'A denúncia de ID ' . $id . ' foi confirmada.',
            'confirmed' => true,
        ]);

        return response()->json(['message' => 'Denúncia confirmada e adicionada ao mapa']);
    }


    public function deleteNotification(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return response()->json(['message' => 'Denúncia excluída']);
    }
}
