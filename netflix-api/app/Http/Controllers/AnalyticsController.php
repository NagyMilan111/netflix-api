<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{

    public function topTen($type, $category, Request $request)
    {
        $validCategories = ['series', 'medias', 'movies', 'genres'];
        $validTypes = ['watched', 'longest', 'shortest'];

        try {
            if (in_array($type, $validTypes)) {
                if (in_array($category, $validCategories)) {

                    if ($type == 'watched') {
                        if ($category == 'series') {
                            $result = DB::select('SELECT * FROM Get_Top_Ten_Watched_Series');
                        } else if ($category == 'movies') {
                            $result = DB::select('SELECT * FROM Get_Top_Ten_Watched_Movies');
                        } else if ($category == 'medias') {
                            $result = DB::select('SELECT * FROM Get_Top_Ten_Watched_Media');
                        } else if ($category == 'genres') {
                            $result = DB::select('SELECT * FROM Get_Top_Ten_Watched_Genres');
                        }
                    } else if ($type == 'longest') {
                        if ($category == 'series') {
                            $result = DB::select('SELECT * FROM Get_Top_Ten_Longest_Series');
                        } else if ($category == 'movies') {
                            $result = DB::select('SELECT * FROM Get_Top_Ten_Longest_Movies');
                        }
                    } else if ($type == 'shortest') {
                        if ($category == 'series') {
                            $result = DB::select('SELECT * FROM Get_Top_Ten_Shortest_Series');
                        } else if ($category == 'movies') {
                            $result = DB::select('SELECT * FROM Get_Top_Ten_Shortest_Movies');
                        }
                    }


                    if ($result != null) {
                        return $this->respond(['values' => $result], $request, 200);
                    } else {
                        return $this->respond(['error' => 'No values found.'], $request, 404);
                    }

                } else {
                    return $this->respond(['error' => 'No matching category.'], $request, 404);
                }
            } else {
                return $this->respond(['error' => 'No matching type.'], $request, 404);
            }


        } catch (\Exception $e) {
            return $this->respond(['error' => $e], $request, 500);
        }
    }

    public function bottomTen($category, Request $request)
    {
        $validCategories = ['series', 'medias', 'movies', 'genres'];

        try {

            if (in_array($category, $validCategories)) {


                if ($category == 'series') {
                    $result = DB::select('SELECT * FROM Get_Bottom_Ten_Series');
                } else if ($category == 'movies') {
                    $result = DB::select('SELECT * FROM Get_Bottom_Ten_Movies');
                } else if ($category == 'medias') {
                    $result = DB::select('SELECT * FROM Get_Bottom_Ten_Media');
                } else {
                    $result = DB::select('SELECT * FROM Get_Bottom_Ten_Genres');
                }

                if ($result != null) {
                    return $this->respond(['values' => $result], $request, 200);
                } else {
                    return $this->respond(['error' => 'No values found.'], $request, 404);
                }
            } else {
                return $this->respond(['error' => 'No matching category.'], $request, 404);
            }

        } catch (\Exception $e) {
            return $this->respond(['error' => $e], $request, 500);
        }
    }

    public function getAllRevenue(Request $request)
    {
        try {
            $result = DB::select('SELECT * FROM Get_All_Revenue');

            if ($result != null) {
                return $this->respond(['values' => $result], $request, 200);
            } else {
                return $this->respond(['error' => 'No revenue found.'], $request, 404);
            }
        } catch (\Exception $e) {
            return $this->respond(['error' => $e], $request, 500);
        }
    }

    public function sortAllByViews($category, Request $request)
    {
        $validCategories = ['series', 'medias', 'movies', 'genres'];
        try {

            if (in_array($category, $validCategories)) {


                if ($category == 'series') {
                    $result = DB::select('SELECT * FROM Get_Watched_Series_By_Views');
                } else if ($category == 'movies') {
                    $result = DB::select('SELECT * FROM Get_Movies_By_Views');
                } else if ($category == 'medias') {
                    $result = DB::select('SELECT * FROM Get_Watched_Media_By_Views');
                } else {
                    $result = DB::select('SELECT * FROM Get_All_Genres_By_Views');
                }

                if ($result != null) {
                    return $this->respond(['values' => $result], $request, 200);
                } else {
                    return $this->respond(['error' => 'No values     found.'], $request, 404);
                }


            } else {
                return $this->respond(['error' => 'No matching category.'], $request, 404);
            }

        } catch (\Exception $e) {
            return $this->respond(['error' => $e], $request, 500);
        }
    }

}

