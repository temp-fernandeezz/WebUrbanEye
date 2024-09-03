<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Log;

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
        ]);

        $report = new Report();
        $report->user_id = auth()->user()->id;
        $report->type = $validated['type'];
        $report->address = $validated['address'];
        $report->city = $validated['city'];
        $report->postal_code = $validated['postal_code'];
        $report->description = $validated['description'];

        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('public/images');
            $report->image_path = basename($imagePath);
        }

        $report->save();

        return redirect()->route('reports.create')->with('success', 'Denúncia enviada com sucesso!');
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
        \Illuminate\Support\Facades\Log::info('Approved locations: ', $reports->toArray());

        return response()->json($reports);
    }
}