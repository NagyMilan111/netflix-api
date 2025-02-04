<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExternalApiController extends Controller
{
    public function generateImage(Request $request)
{
    $request->validate([
        'prompt' => 'required|string|max:255',
    ]);

    $prompt = $request->input('prompt');
    $baseUrl = 'https://image.pollinations.ai/prompt';

    try {
        // Make the API call
        $response = Http::withoutVerifying()->get("{$baseUrl}/{$prompt}");

        // Log the headers for debugging
        \Log::info('External API Headers:', $response->headers());

        // Check if the response is an image
        $contentType = $response->header('Content-Type');

        if (strpos($contentType, 'image') !== false) {
            // Save the image locally
            $fileName = uniqid('image_') . '.jpg';
            $filePath = public_path('generated_images/' . $fileName);

            // Ensure the directory exists
            if (!is_dir(public_path('generated_images'))) {
                mkdir(public_path('generated_images'), 0755, true);
            }

            // Write the binary data to a file
            file_put_contents($filePath, $response->body());

            // Return the public URL of the saved image
            return $this->respond([
                'prompt' => $prompt,
                'image_url' => url('generated_images/' . $fileName),
            ], $request, 201);
        }

        // If the response is not an image
        \Log::error('Unexpected API Response', ['body' => $response->body()]);
        return $this->respond(['error' => 'Unexpected response from the API.'], $request, 500);

    } catch (\Exception $e) {
        \Log::error('Image Generation Error:', ['message' => $e->getMessage()]);
        return $this->respond(['error' => 'An error occurred while processing your request.'], $request, 500);
    }
}

}
