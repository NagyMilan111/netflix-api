<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function handleRequest($endpoint, Request $request)
    {
        switch ($endpoint) {
            // Account endpoints
            case 'account/login':
                return app(AccountController::class)->login($request);
            case 'account/register':
                return app(AccountController::class)->register($request);

            // Token endpoints
            case 'token/generate':
                return app(TokenController::class)->generateToken($request->input('userId'));

            // Media endpoints
            case 'media/play':
                return app(MediaController::class)->playMedia($request->input('mediaId'));

            // Subscription endpoints
            case 'subscription/details':
                return app(SubscriptionController::class)->getSubscriptionDetails($request->input('userId'));

            // External API endpoints
            case 'external/generate-image':
                return app(ExternalApiController::class)->generateImage($request);

            // Episode endpoints
            case 'episode/index':
                return app(EpisodeController::class)->index($request);
            case 'episode/show':
                return app(EpisodeController::class)->show($request->input('id'));
            case 'episode/store':
                return app(EpisodeController::class)->store($request);
            case 'episode/update':
                return app(EpisodeController::class)->update($request->input('id'), $request);
            case 'episode/destroy':
                return app(EpisodeController::class)->destroy($request->input('id'));

            // Series endpoints
            case 'series/index':
                return app(SeriesController::class)->index($request);
            case 'series/show':
                return app(SeriesController::class)->show($request->input('id'));
            case 'series/store':
                return app(SeriesController::class)->store($request);
            case 'series/update':
                return app(SeriesController::class)->update($request->input('id'), $request);
            case 'series/destroy':
                return app(SeriesController::class)->destroy($request->input('id'));

            // Default response for invalid endpoints
            default:
                return response()->json(['error' => 'Invalid endpoint'], 404);
        }
    }
}
