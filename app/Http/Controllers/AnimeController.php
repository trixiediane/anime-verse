<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    public function getTopAnime()
    {
        $client = new Client();

        try {
            $response = $client->get('https://api.jikan.moe/v4/top/anime', [
                'verify' => false,
            ]);

            $result = json_decode($response->getBody()->getContents(), true);

            return response()->json($result);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
