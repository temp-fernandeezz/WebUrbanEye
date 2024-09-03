<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class LocationSearch extends Controller
{
    public function search(Request $request)
    {
        $searchTerm = $request->query('search_term');

        $report = Report::where('address', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('postal_code', $searchTerm)
                        ->orWhere('city', 'LIKE', '%' . $searchTerm . '%')
                        ->first();

        if ($report) {
            return response()->json([
                'latitude' => $report->latitude,
                'longitude' => $report->longitude,
                'description' => $report->description
            ]);
        } else {
            return response()->json(['error' => 'Local não encontrado'], 404); 
        }
    }
}
