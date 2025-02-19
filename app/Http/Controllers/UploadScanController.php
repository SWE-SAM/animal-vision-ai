<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadScanController extends Controller
{
    public function index()
    {
        return view('uploadscan'); // Renders the view with navbar/sidebar
    }

    public function process(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $image = $request->file('image');
        $imageName = time().'.'.$image->extension();
        $image->move(public_path('uploads'), $imageName);

        return back()->with('success', 'Image uploaded successfully!');
    }
}
