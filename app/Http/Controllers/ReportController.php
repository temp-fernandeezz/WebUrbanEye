<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use App\Notifications\RobberyAlertNotification;
use Illuminate\Http\Request;
use App\Notifications\ReportNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $reports = Report::where('user_id', $userId)->get();

        return view('dashboard', compact('reports'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => '',
            'type' => 'required|string|in:flood,illegal_dump,robberies',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // Recuperar latitude e longitude usando o CEP
        $postalCode = $validated['postal_code'];
        $geoData = $this->getGeocodeData($postalCode);

        $report = new Report();
        $report->user_id = auth()->user()->id;
        $report->type = $validated['type'];
        $report->address = $validated['address'];
        $report->city = $validated['city'];
        $report->postal_code = $validated['postal_code'];
        $report->description = $validated['description'];
        $report->latitude = $geoData['latitude'] ?? null;
        $report->longitude = $geoData['longitude'] ?? null;

        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('public/images');
            $report->image_path = basename($imagePath);
        }

        // Salvar o relatório antes de enviar as notificações
        $report->save();

        if ($report->type === 'robberies') {
            $radius = 500; // Raio em metros
            $users = User::all()->filter(function ($user) use ($report, $radius) {
                // Verifica se o usuário está dentro do raio especificado
                $distance = $user->distanceTo($report->latitude, $report->longitude);
                return $distance <= $radius;
            });

            // Enviar a notificação para os usuários encontrados
            Notification::send($users, new RobberyAlertNotification($report));
        }

        return redirect()->route('reports.create')->with('success', 'Denúncia enviada com sucesso!');
    }

    private function getGeocodeData($postalCode)
    {
        // Substitua pela sua API de geocodificação
        $apiKey = 'AIzaSyBn0Hr_x0v-_EhdIbcEbF_H_AKEuqbMcLc';
        $response = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address={$postalCode}&key={$apiKey}");
        $data = json_decode($response, true);

        if ($data['status'] === 'OK') {
            $location = $data['results'][0]['geometry']['location'];
            return [
                'latitude' => $location['lat'],
                'longitude' => $location['lng']
            ];
        }

        return [
            'latitude' => null,
            'longitude' => null
        ];
    }

    public function show(Report $report)
    {
        return view('pages.listReport', compact('report'));
    }

    public function list()
    {
        $userId = auth()->user()->id;
        $reports = Report::where('user_id', $userId)->get();

        return view('pages.listReport', compact('reports'));
    }

    public function getApprovedLocations()
    {
        $reports = Report::where('status', 'approved')->get(['latitude', 'longitude', 'description', 'type']);

        // Adicione logs para verificar os dados
        Log::info('Approved locations: ', $reports->toArray());

        return response()->json($reports);
    }

    // public function getNotifications()
    // {
    //     // Verificar se o usuário está autenticado
    //     if (!auth()->check()) {

    //         return response()->json(['error' => 'Usuário não autenticado'], 401);
    //     }
    
    //     // Se o usuário estiver autenticado, obtenha o ID do usuário
    //     $userId = auth()->user()->id;
    
    //     // Obtenha os relatórios do usuário ou de relatórios sem user_id e tipo 'robberies'
    //     $reports = Report::where('user_id', $userId)
    //         ->orWhere(function ($query) {
    //             $query->where('type', 'robberies')
    //                   ->orWhereNull('user_id');
    //         })
    //         ->get();
    
    //     // Retorna os relatórios encontrados
    //     return response()->json($reports);
    // }
    


    // public function confirmNotification(Request $request, $id)
    // {
    //     $report = Report::findOrFail($id);
    //     // Atualizar o status da denúncia para confirmado e adicioná-la ao mapa
    //     $report->update(['status' => 'confirmed']); // Atualizar o status conforme necessário

    //     return response()->json(['message' => 'Denúncia confirmada e adicionada ao mapa']);
    // }

    // public function deleteNotification(Request $request, $id)
    // {
    //     $report = Report::findOrFail($id);
    //     $report->delete();

    //     return response()->json(['message' => 'Denúncia excluída']);
    // }
}
