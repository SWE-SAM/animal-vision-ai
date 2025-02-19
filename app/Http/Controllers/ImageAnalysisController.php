<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AzureImageAnalyzer;

class ImageAnalysisController extends Controller
{
    protected $azureImageAnalyzer;

    public function __construct(AzureImageAnalyzer $azureImageAnalyzer)
    {
        $this->azureImageAnalyzer = $azureImageAnalyzer;
    }

    public function analyze(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $imagePath = $request->file('image')->path();
        $analysisResult = $this->azureImageAnalyzer->analyzeImage($imagePath);

        return response()->json($analysisResult);
    }
}
