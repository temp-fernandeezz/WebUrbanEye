<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Report;
use App\Models\User;
use App\Notifications\RobberyAlertNotification;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
{
    $userId = auth()->user()->id;
    $reports = Report::where('user_id', $userId)->get();

    return response()->json($reports);
}

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Usuário não autenticado'], 401);
        }

        $validated = $request->validate([
            'type' => 'required|string|in:flood,illegal_dump,robberies',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $postalCode = $validated['postal_code'];
        $geoData = $this->getGeocodeData($postalCode);

        $report = new Report();
        $report->user_id = auth()->id();
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

        $report->save();

        if ($report->type === 'robberies') {
            $radius = 500;
            $users = User::all()->filter(function ($user) use ($report, $radius) {
                $distance = $user->distanceTo($report->latitude, $report->longitude);
                return $distance <= $radius;
            });

            Notification::send($users, new RobberyAlertNotification($report));
        }

        return response()->json(['message' => 'Relatório criado com sucesso!']);
    }




    private function getGeocodeData($postalCode)
    {
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
        $userId = auth()->user()->id;
        $reports = Report::where('user_id', $userId)->get();

        return response()->json($reports);
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
        \Log::info('Approved locations: ', $reports->toArray());

        return response()->json($reports);
    }
}