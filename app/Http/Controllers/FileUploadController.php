<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        // Validasi file yang diupload
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,pdf|max:2048', // Maksimal 2MB dan hanya menerima jpg, png, pdf
        ]);

        // Simpan file
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Tentukan nama file yang unik
            $fileName = time().'_'.$file->getClientOriginalName();

            // Simpan file ke folder 'uploads'
            $filePath = $file->storeAs('uploads', $fileName, 'public');

            // Kirim response sukses
            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully!',
                'file_path' => url('/storage/' . $filePath)
            ], 201);
        }

        // Kirim response jika gagal
        return response()->json([
            'success' => false,
            'message' => 'File upload failed!'
        ], 400);
    }
}
