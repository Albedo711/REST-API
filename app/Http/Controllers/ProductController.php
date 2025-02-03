<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $products = Product::all();
        
        return response()->json([
            'success' => true,
            'data' => $products
        ], 200);
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);
    
        if ($validator->fails( )) {
            return response()->json([
                'errors' => [
                    'message' => [
                        'bad request'
                    ]
                ]
            ], 400);
        }
    
        $product = Product::create($request->all());
    
        return response()->json([
            'success' => true,
            'data'    => $product,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        if (!$product){
            $product = Product::where('name', 'LIKE', "%{$id}%")->first();
        }
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }
        return response()->json([
        'success' => true,
        'data' => $product
        ], 200); 
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
        $product = Product::find($id);
        if (!$product) {
        return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0', 
        ]);
        $product->update($request->all());
        return response()->json([
        'success' => true,
        'data' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if (!$product) {
        return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }
        $product->delete();
        return response()->json([], 204); 
       
    }
}
