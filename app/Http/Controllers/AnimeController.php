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

    public function byCategory(Request $request)
    {
        try {
            $userId = auth()->id();  // Get the ID of the currently authenticated user

            // Check if the category belongs to the current user
            $category = Category::where('id', $request->category_id)
                ->where('user_id', $userId)
                ->firstOrFail();

            return view('anime.index');
        } catch (ModelNotFoundException $e) {
            return view('auth.404');
            // return response()->json(['message' => 'Category not found or not owned by you.', 'error' => $e->getMessage(), 'status' => 404]);
        } catch (Exception $e) {
            return response()->json(['message' => 'There was an error retrieving the anime under the category.', 'error' => $e->getMessage(), 'status' => 400]);
        }
    }

    public function store(StoreAnimeRequest $request)
    {
        try {
            $animes = Anime::create([
                'category_id' => $request->category_id,
                'anime_id' => $request->anime_id
            ]);

            return response()->json(['message' => 'Successfully added the anime in your category!', 'data' => $animes, 'status' => 200]);
        } catch (Exception $e) {
            return response()->json(['message' => 'There is an error adding the anime in this category', 'error' => $e->getMessage(), 'status' => 400]);
        }
    }


    public function update(UpdateAnimeRequest $request)
    {
        try {
            $anime = Anime::findOrFail($request->animeId);

            $animeUpdate = $anime->update([
                'category_id' => $request->category_id,
                'anime_id' => $request->anime_id
            ]);

            return response()->json(['message' => 'Successfully updated the anime in your category!', 'data' => $animeUpdate, 'status' => 200]);
        } catch (Exception $e) {
            return response()->json(['message' => 'There is an error updating the anime in this category', 'error' => $e->getMessage(), 'status' => 400]);
        }
    }

    public function destroy($animeId)
    {
        try {
            // Find the anime by ID or fail if not found
            $anime = Anime::findOrFail($animeId);

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
}
