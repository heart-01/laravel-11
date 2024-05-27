<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Read all products
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->tokenCan("1")) {
            // Validate form
            $request->validate([
                'name' => 'required|min:3',
                'slug' => 'required',
                'price' => 'required'
            ]);

            $product = array(
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'slug' => $request->input('slug'),
                'price' => $request->input('price'),
                'user_id' => $user->id
            );

            // Create data to tabale product
            $newProduct = Product::create($product);

            $response = [
                'status' => true,
                'message' => "Product created successfully",
                'product' => $newProduct,
            ];

            return response($response, 201);

        }

        return response([
            'status' => false,
            'message' => 'Permission denied to create'
        ], 403);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::find($id);

        if ($product) {
            return response([
                'status' => true,
                'product' => $product
            ]);
        }

        return response([
            'status' => false,
            'message' => 'Product not found'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();

        if ($user->tokenCan("1")) {

            $request->validate([
                'name' => 'required',
                'slug' => 'required',
                'price' => 'required'
            ]);

            $data_product = array(
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'slug' => $request->input('slug'),
                'price' => $request->input('price'),
                'user_id' => $user->id
            );

            $product = Product::find($id);
            $product->update($data_product);

            return response([
                'status' => true,
                'message' => 'Product updated successfully',
                'product' => $product
            ]);
        }

        return response([
            'status' => false,
            'message' => 'Permission denied to create'
        ], 403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = auth()->user();

        if ($user->tokenCan("1")) {
            $product = Product::destroy($id);

            if ($product) {
                return response([
                    'status' => true,
                    'message' => 'Product deleted successfully'
                ]);
            }

            return response([
                'status' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response([
            'status' => false,
            'message' => 'Permission denied to create'
        ], 403);
    }
}
