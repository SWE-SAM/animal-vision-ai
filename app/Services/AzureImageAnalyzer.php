<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class AzureImageAnalyzer
{
    protected $client;
    protected $endpoint;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->endpoint = env('AZURE_VISION_ENDPOINT') . '/vision/v3.2/analyze?visualFeatures=Description,Tags,Objects';
        $this->apiKey = env('AZURE_VISION_KEY');
    }

    public function analyzeImage($imagePath)
    {
        try {
            $response = $this->client->post($this->endpoint, [
                'headers' => [
                    'Ocp-Apim-Subscription-Key' => $this->apiKey,
                    'Content-Type' => 'application/octet-stream',
                ],
                'body' => file_get_contents($imagePath),
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error('Azure AI Vision error: ' . $e->getMessage());
            return ['error' => 'Image analysis failed.'];
        }
    }
}
