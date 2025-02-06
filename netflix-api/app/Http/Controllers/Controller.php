<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Spatie\ArrayToXml\ArrayToXml;
use Illuminate\Http\Request;

abstract class Controller
{
    /**
     * Respond with JSON or XML based on the Accept header.
     *
     * @param array|object $data The response data.
     * @param Request $request The incoming request.
     * @param int $status The HTTP status code.
     * @return \Illuminate\Http\Response
     */
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
