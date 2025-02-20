<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AzureImageAnalyzer;

class UploadScanController extends Controller
{
    public function index()
    {
        return view('uploadscan'); // Renders the upload scan page
    }

    public function process(Request $request, AzureImageAnalyzer $azureImageAnalyzer)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Store the uploaded image
        $image = $request->file('image');
        $imageName = time().'_'.uniqid().'.'.$image->extension();
        $imagePath = $image->storeAs('uploads', $imageName, 'local'); // Store in storage/app/uploads/

        // Get the absolute path
        $fullPath = storage_path("app/$imagePath");

        // Analyze the image using Azure AI
        try {
            $analysisResult = $azureImageAnalyzer->analyzeImage($fullPath);
            return response()->json([
                'success' => true,
                'message' => 'Image uploaded and analyzed successfully!',
                'analysis' => $analysisResult,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Image analysis failed: ' . $e->getMessage()], 500);
        }
    }
}
