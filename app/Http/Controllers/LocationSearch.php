<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class LocationSearch extends Controller
{
    public function search(Request $request)
{
    $postalCode = $request->query('postal_code'); // Corrige o nome do parâmetro

    $report = Report::where('postal_code', $postalCode)->first();

    if ($report) {
        return response()->json([
            'address' => $report->address,
            'latitude' => $report->latitude,
            'longitude' => $report->longitude,
            'description' => $report->description
        ]);
    } else {
        return response()->json(['error' => 'Local não encontrado'], 404); 
    }
}

}
