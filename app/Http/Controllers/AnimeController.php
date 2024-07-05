<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    public function getTopAnime(Request $request)
    {
        $client = new Client();
        $queryParams = [];

        // Optional query parameters
        if ($request->has('type')) {
            $queryParams['type'] = $request->input('type');
        }
        if ($request->has('filter')) {
            $queryParams['filter'] = $request->input('filter');
        }
        if ($request->has('rating')) {
            $queryParams['rating'] = $request->input('rating');
        }
        if ($request->has('sfw')) {
            $queryParams['sfw'] = $request->input('sfw');
        }
        if ($request->has('page')) {
            $queryParams['page'] = $request->input('page');
        }
        if ($request->has('limit')) {
            $queryParams['limit'] = $request->input('limit');
        }

        $url = 'https://api.jikan.moe/v4/top/anime';

        try {
            $response = $client->get($url, [
                'query' => $queryParams,
                'verify' => false,
            ]);

            $result = json_decode($response->getBody()->getContents(), true);

            return response()->json($result);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
