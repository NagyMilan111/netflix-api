<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainApiController extends Controller
{
    public function routeRequest(Request $request, $endpoint)
    {
        $apiController = new ApiController();
        return $apiController->handleRequest($endpoint, $request);
    }
}
