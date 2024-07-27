<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnimeRequest;
use App\Http\Requests\UpdateAnimeRequest;
use App\Models\Anime;
use App\Models\Category;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AnimeController extends Controller
{
    public function show($id)
    {
        $client = new Client();
        $url = 'https://api.jikan.moe/v4/anime/' . $id . '/full';

        try {
            $response = $client->get($url, ['verify' => false]);
            $result = json_decode($response->getBody()->getContents(), true);

            $userId = auth()->id();  // Get the ID of the currently authenticated user

            // Check if the category belongs to the current user
            $categories = Category::where('user_id', $userId)
                ->get();

            return view('anime.show', ['anime' => $result['data'], 'categories' => $categories]);
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

    public function store(StoreAnimeRequest $request)
    {
        try {
            $userId = auth()->id();
            $animeId = $request->anime_id;
            $category_id = $request->category_id;

            // Check if the user already has this anime_id
            $exists = Anime::where('user_id', $userId)
                ->where('anime_id', $animeId)
                ->where('category_id', $category_id)
                ->exists();

            if ($exists) {
                return response()->json(['message' => 'This anime is already in this category!', 'status' => 400]);
            }

            $animes = Anime::create([
                'user_id' => $userId,
                'category_id' => $category_id,
                'anime_id' => $animeId
            ]);

            return response()->json(['message' => 'Successfully added the anime in your category!', 'data' => $animes, 'status' => 200]);
        } catch (Exception $e) {
            return response()->json(['message' => 'There is an error adding the anime in this category', 'error' => $e->getMessage(), 'status' => 400]);
        }
    }



    public function update(UpdateAnimeRequest $request)
    {
        try {
            $userId = auth()->id();
            $animeId = $request->anime_id;
            $category_id = $request->category_id;

            // Check if the user already has this anime_id
            $exists = Anime::where('user_id', $userId)
                ->where('anime_id', $animeId)
                ->where('category_id', $category_id)
                ->exists();

            if ($exists) {
                return response()->json(['message' => 'This anime is already in this category!', 'status' => 400]);
            }

            $anime = Anime::where('anime_id', $animeId)
                ->where('user_id', $userId)
                ->first();

            $animeUpdate = $anime->update([
                'category_id' => $request->category_id
            ]);

            return response()->json(['message' => 'Successfully updated the anime in your category!', 'data' => $animeUpdate, 'status' => 200]);
        } catch (Exception $e) {
            return response()->json(['message' => 'There is an error updating the anime in this category', 'error' => $e->getMessage(), 'status' => 400]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            // Find the anime by ID or fail if not found
            $anime = Anime::findOrFail($request->anime_id);
            Log::debug($anime);

            // Delete the anime
            $anime->delete();

            return response()->json([
                'message' => 'Successfully removed the anime from the category!',
                'status' => 200
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Anime not found',
                'error' => $e->getMessage(),
                'status' => 404
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'There was an error deleting the anime',
                'error' => $e->getMessage(),
                'status' => 400
            ]);
        }
    }

    public function fetchAnimeData(Request $request)
    {
        // Get anime IDs and their corresponding IDs from the anime table
        $animeRecords = Anime::where('category_id', $request->category_id)
            ->pluck('anime_id', 'id');

        // Initialize Guzzle client
        $client = new Client();

        // Log::debug('Anime Records:', $animeRecords->toArray()); // Log all anime records

        $animeData = [];

        foreach ($animeRecords as $animeTableId => $animeId) {
            $url = 'https://api.jikan.moe/v4/anime/' . $animeId . '/full';

            try {
                $response = $client->get($url, ['verify' => false]);
                $result = json_decode($response->getBody()->getContents(), true);

                if (isset($result['data'])) {
                    // Log::debug($animeTableId);
                    // Include anime table ID in the response
                    $animeData[] = [
                        'anime_table_id' => $animeTableId,
                        'mal_id' => $result['data']['mal_id'] ?? null,
                        'title' => $result['data']['title'] ?? null,
                    ];
                } else {
                    Log::warning('No data found for anime ID:', ['anime_id' => $animeId]);
                }
            } catch (Exception $e) {
                Log::error('API request failed:', ['url' => $url, 'message' => $e->getMessage()]);
            }

            // Optional: Add delay to avoid hitting rate limits
            sleep(1);
        }

        // Return the anime data
        return response()->json($animeData);
    }
}
