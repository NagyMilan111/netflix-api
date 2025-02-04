<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    
    class ApiController extends Controller
    {
        public function handleRequest($endpoint, Request $request)
        {
            switch ($endpoint) {
                case 'account/login':
                    return app(AccountController::class)->login($request);
                case 'account/register':
                    return app(AccountController::class)->register($request);
                case 'token/generate':
                    return app(TokenController::class)->generateToken($request->input('userId'));
                case 'media/play':
                    return app(MediaController::class)->playMedia($request->input('mediaId'));
                case 'subscription/details':
                    return app(SubscriptionController::class)->getSubscriptionDetails($request->input('userId'));
                case 'external/generate-image':
                    return app(ExternalApiController::class)->generateImage($request);
                default:
                    return response()->json(['error' => 'Invalid endpoint'], 404);
            }
        }
    }
    
?>