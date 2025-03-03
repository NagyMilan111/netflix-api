<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApiKeyController extends Controller
{

    public function generate(Request $request)
    {
        try {

            $api_key = str::random(64);

            DB::select('CALL Insert_Api_Key(?, @message)', [$api_key]);
            $result = DB::select('SELECT @message as message')[0];

            $message = $result->message;

            if ($message == 'Api key inserted successfully.') {
                return $this->respond(['api_key' => $api_key, 'message' => $message], $request, 201);
            } else {
                return $this->respond(['error' => $message], $request, 500);
            }
        } catch (\Exception $e) {
            return $this->respond(['error' => $e], $request, 500);
        }
    }

    public function refresh(Request $request)
    {
        try {

            $header = $request->header('Netflix-Api-Key');

            $api_key = str::random(64);

            DB::select('CALL Update_Api_Key(?, ?, @message)', [$header, $api_key]);
            $result = DB::select('SELECT @message as message')[0];

            $message = $result->message;

            if ($message == 'Api key updated successfully.') {
                return $this->respond(['api_key' => $api_key, 'message' => $message], $request, 200);
            } else {
                return $this->respond(['error' => $message], $request, 500);
            }

        } catch (\Exception $e) {
            return $this->respond(['error' => $e], $request, 500);
        }
    }

    public function revoke(Request $request)
    {
        $header = $request->header('Netflix-Api-Key');

        DB::select('CALL Revoke_Api_Key(?, @message)', [$header]);

        $result = DB::select('SELECT @message as message')[0];
        $message = $result->message;
        if ($message == 'Api key revoked successfully.') {
            return $this->respond(['message' => $message], $request, 200);
        } else {
            return $this->respond(['error' => $message], $request, 500);
        }
    }

}
