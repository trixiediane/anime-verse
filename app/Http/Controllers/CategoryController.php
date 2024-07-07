<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
