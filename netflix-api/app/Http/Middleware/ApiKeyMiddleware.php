<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\DB;
use Spatie\ArrayToXml\ArrayToXml;

class ApiKeyMiddleware extends Middleware
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('Netflix-Api-Key');

        $apiKeyExists = DB::select('SELECT * FROM Get_Api_Key WHERE api_key = ?', [$apiKey]);

        if (!$apiKeyExists) {
            return $this->respond(['error' => 'Invalid Api key.'], $request, 401);
        } else {
            if (Carbon::now()->greaterThan($apiKeyExists[0]->expire_at)) {
                return response()->json(['error' => 'API key expired.'], 401);
            }

            return $next($request);
        }
    }

    protected function respond($data, Request $request, $status = 200)
    {
        if ($request->header('Accept') === 'application/xml') {
            // Convert data to XML
            $dataArray = json_decode(json_encode($data), true); // Ensure data is an array
            $xml = ArrayToXml::convert($dataArray, 'root');
            return response($xml, $status)->header('Content-Type', 'application/xml')
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        }

        // Default to JSON
        return response()->json($data, $status)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }
}