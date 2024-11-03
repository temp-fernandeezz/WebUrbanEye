<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Notifications\RiskAlertNotification;
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

    public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'title' => 'required|string', // Validação para o título
    ]);

    // Criar a notificação
    Notification::create([
        'user_id' => $request->user_id,
        'title' => $request->title, // Atribua o título a partir da requisição
    ]);

    return response()->json(['message' => 'Notificação criada com sucesso.']);
}



    public function deleteNotification(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return response()->json(['message' => 'Denúncia excluída']);
    }

    public function checkRiskArea(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $type = $request->input('type');

        // Logica para verificar se a localização está em uma área de risco
        $isInRiskArea = $this->checkIfInRiskArea($latitude, $longitude, $type);

        if ($isInRiskArea) {
            $user = auth()->user(); // ou $request->user() se estiver usando autenticação via token
            $user->notify(new RiskAlertNotification($type));
            
            return response()->json(['message' => 'Notificação enviada.']);
        }

        return response()->json(['message' => 'Fora da área de risco.']);
    }

    public function savePushToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        // Aqui você pode salvar o token no banco de dados, por exemplo:
        $user = auth()->user();
        $user->update(['push_token' => $request->token]);

        return response()->json(['message' => 'Token salvo com sucesso.']);
    }

    private function checkIfInRiskArea($latitude, $longitude, $type)
    {
        // Implemente a lógica de verificação de área de risco
        return true; // Retorne true ou false conforme a verificação
    }
}
