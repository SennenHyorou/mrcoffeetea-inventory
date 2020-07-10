<?php

namespace App\Http\Controllers\Api;

use Str;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\Category\StoreRequest;

class CategoryController extends Controller
{
    private function formatResponse($message = "", $data = []) {
        return array(
            "data" => $data,
            "message" => $message
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return response()->json(
            $this->formatResponse("All categories", $categories), 200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        try {
            $category = new Category();
            $category->name = $request->get('name');
            $category->slug = Str::slug($request->get('name'));
            if ($category->save())
            {
                return response()->json(
                    $this->formatResponse("Category created", $category), 200
                );
            } else {
                return response()->json(
                    $this->formatResponse("Failed to create category"), 500
                );
            }
        } catch (\Throwable $throw) {
            return response()->json(
                $this->formatResponse("There is an error with the server"), 500
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            $category = Category::find($request->id);
            if (!$category) return response()->json($this->formatResponse("Data not available"), 400);

            return response()->json(
                $this->formatResponse("1 Category", $category), 200
            );
        } catch (\Throwable $th) {
            return response()->json(
                $this->formatResponse("There is an error with the server"), 500
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update($id, StoreRequest $request)
    {
        try {
            $category = Category::find($request->id);
            if (!$category) return response()->json($this->formatResponse("Data not available"), 400);

            $category->name = $request->get('name');
            $category->slug = Str::slug($request->get('name'));
            $category->save();
            
            if ($category->save())
            {
                return response()->json(
                    $this->formatResponse("Category updated", $category), 200
                );
            } else {
                return response()->json(
                    $this->formatResponse("Failed to update category"), 500
                );
            }
        } catch (\Throwable $th) {
            return response()->json(
                $this->formatResponse("There is an error with the server"), 500
            );
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $category = Category::find($request->id);
            if (!$category) return response()->json($this->formatResponse("Data not available"), 400);
            $category->delete();
            
            return response()->json(
                $this->formatResponse("Category deleted", $category), 200
            );
        } catch (\Throwable $th) {
            return response()->json(
                $this->formatResponse("There is an error with the server"), 500
            );
        }
    }
}
