<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateReport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'type' => 'required|in:projects,employees',
        ]);

        GenerateReport::dispatch($request->type);

        return response()->json(['message' => 'Report generation initiated'], 200);
    }
}

