<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;

    class ApiController extends Controller
    {
        public function handleRequest($endpoint, $data)
        {
            switch ($endpoint) {
                case 'user/profile':
                    $controller = new UserAccountController();
                    return $controller->addProfile(new Request($data));
                case 'account/login':
                    $controller = new AccountController();
                    return $controller->login(new Request($data));
                case 'token/generate':
                    $controller = new TokenController();
                    return $controller->generateToken($data['userId']);
                case 'media/play':
                    $controller = new MediaController();
                    return $controller->playMedia($data['mediaId']);
                case 'subscription/details':
                    $controller = new SubscriptionController();
                    return $controller->getSubscriptionDetails($data['userId']);
                case 'profile/update':
                    $controller = new ProfileController12();
                    return $controller->updatePreferences(new Request($data));
                default:
                    return response()->json(['error' => 'Invalid endpoint'], 404);
            }
        }
    }
?>