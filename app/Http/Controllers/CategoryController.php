<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function list(Request $request)
    {
        try {
            $categories = Category::where('user_id', $request->user_id)
                ->get();

            return response()->json(['message' => 'Successfully retrieved list of categories.', 'data' => $categories, 'status' => 200]);
        } catch (Exception $e) {
            return response()->json(['message' => 'There is an error retrieving list of categories', 'error' => $e->getMessage(), 'status' => 400]);
        }
    }

    public function category(Request $request)
    {
        try {

            $category = Category::where('id', $request->category_id)
                ->first();

            return response()->json(['message' => 'Successfully retrieved category information.', 'data' => $category, 'status' => 200]);
        } catch (Exception $e) {
            return response()->json(['message' => 'There is an error retrieving category information.', 'error' => $e->getMessage(), 'status' => 400]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            $categories = Category::create([
                'user_id' => $request->user_id,
                'name' => $request->name,
                'description' => $request->description
            ]);

            return response()->json(['message' => 'Successfully created a category!', 'data' => $categories, 'status' => 200]);
        } catch (Exception $e) {
            return response()->json(['message' => 'There is an error creating a category', 'error' => $e->getMessage(), 'status' => 400]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request)
    {
        try {
            $category = Category::findOrFail($request->id);

            $category->update([
                'name' => $request->name,
                'description' => $request->description
            ]);

            return response()->json(['message' => 'Successfully updated the category information.', 'data' => $category, 'status' => 200]);
        } catch (Exception $e) {
            return response()->json(['message' => 'There is an error updating category information.', 'error' => $e->getMessage(), 'status' => 400]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);

            $category->delete();

            return response()->json([
                'message' => 'Successfully deleted the category!',
                'status' => 200
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
