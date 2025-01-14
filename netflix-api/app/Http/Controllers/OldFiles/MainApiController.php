<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;

    class MainApiController extends Controller
    {
        public function routeRequest($endpoint, Request $request)
        {
            // Centralized API request router
            $apiController = new ApiController();
            return $apiController->handleRequest($endpoint, $request->all());
        }
    }
?>