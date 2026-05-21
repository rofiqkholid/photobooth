<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\PhotoboothMail;

class PhotoController extends Controller
{
    public function sendPhoto(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'image' => 'required|string', // Base64 data URI
        ]);

        try {
            $email = $request->input('email');
            $base64Image = $request->input('image');

            // Extract base64 content from data URI
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
                $type = strtolower($type[1]); // e.g. jpeg, png
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Format gambar tidak valid.'
                ], 400);
            }

            $imageBinary = base64_decode($base64Image);
            if ($imageBinary === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dekode gambar gagal.'
                ], 400);
            }

            // Define public upload directory (Hostinger compatible)
            $dirPath = public_path('uploads/photos');
            if (!file_exists($dirPath)) {
                mkdir($dirPath, 0755, true);
            }

            // Generate unique filename
            $filename = 'photobooth_' . time() . '_' . uniqid() . '.' . ($type === 'jpeg' ? 'jpg' : $type);
            $filePath = str_replace('\\', '/', $dirPath . '/' . $filename);

            // Save the file
            file_put_contents($filePath, $imageBinary);

            // Send Mail
            Mail::to($email)->send(new PhotoboothMail($filePath));

            return response()->json([
                'success' => true,
                'message' => 'Foto Anda telah berhasil dikirim ke email ' . $email . '!'
            ]);

        } catch (\Exception $e) {
            Log::error('Photobooth sendPhoto error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim email: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showDownload($filename)
    {
        $filePath = public_path('uploads/photos/' . $filename);
        if (!file_exists($filePath)) {
            abort(404, 'Foto tidak ditemukan.');
        }

        $imageUrl = asset('uploads/photos/' . $filename);

        return view('download', [
            'imageUrl' => $imageUrl,
            'filename' => $filename,
        ]);
    }

    public function downloadFile($filename)
    {
        $filePath = public_path('uploads/photos/' . $filename);
        if (!file_exists($filePath)) {
            abort(404, 'Foto tidak ditemukan.');
        }

        return response()->download($filePath, 'mosafe-photobooth-' . $filename);
    }
}
