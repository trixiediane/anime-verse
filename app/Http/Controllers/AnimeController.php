<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Category;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    public function show($id)
    {
        $client = new Client();
        $url = 'https://api.jikan.moe/v4/anime/' . $id . '/full';

        try {
            $response = $client->get($url, ['verify' => false]);
            $result = json_decode($response->getBody()->getContents(), true);

            return view('anime.show', ['anime' => $result['data']]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

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

    public function byCategory(Request $request)
    {
        try {
            $userId = auth()->id();  // Get the ID of the currently authenticated user

            // Check if the category belongs to the current user
            $category = Category::where('id', $request->category_id)
                ->where('user_id', $userId)
                ->firstOrFail();

            // Retrieve anime that belongs to the category
            $anime = Anime::where('category_id', $request->category_id)
                ->get();

            return view('anime.index', ['anime' => $anime]);
        } catch (ModelNotFoundException $e) {
            return view('auth.404');
            // return response()->json(['message' => 'Category not found or not owned by you.', 'error' => $e->getMessage(), 'status' => 404]);
        } catch (Exception $e) {
            return response()->json(['message' => 'There was an error retrieving the anime under the category.', 'error' => $e->getMessage(), 'status' => 400]);
        }
    }
}
