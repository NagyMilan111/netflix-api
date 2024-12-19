<?php

    namespace App\Http\Controllers;

    class MediaController extends Controller
    {
        public function playMedia($id)
        {
            return response()->json(['message' => 'Media is playing']);
        }

        public function pauseMedia($id)
        {
            return response()->json(['message' => 'Media paused']);
        }

        public function resumeMedia($id)
        {
            return response()->json(['message' => 'Media resumed']);
        }
    }
?>