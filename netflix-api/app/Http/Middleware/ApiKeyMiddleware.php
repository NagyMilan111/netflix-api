<?php

namespace app\Http\Middleware;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\DB;


class ApiKeyMiddleware extends Middleware
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('Netflix-Api-Key');

        $apiKeyExists = DB::select('SELECT * FROM Get_Api_Key WHERE api_key = ?', [$apiKey]);

        if (!$apiKeyExists) {
            return $this->respond(['error' => 'Invalid Api key.'], $request, 401);
        } else {

            if (Carbon::now()->greaterThan($apiKeyExists[0]->expires_at)) {
                return response()->json(['error' => 'API key expired.'], 401);
            }

            return $next($request);
        }
    }

}
