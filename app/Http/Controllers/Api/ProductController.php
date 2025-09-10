<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
         Product::create($request->validated());
         return response()->json([
            'message'=>'Record Saved!', 
         ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        if($product){
            return new ProductResource($product);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductRequest $request, string $id)
    {
        $validated = $request->validated();
        $product = Product::findOrFail($id);
        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('uploads/products', 'public');
        }
        $product->fill($validated);
        if ($product->isDirty()) {
            $product->save();
            return response()->json([
                'message' => 'Record is Updated!',
                'change' => true,
                'data' => $product, 
            ]);
    }

    return response()->json([
        'message' => 'No changes detected.',
        'change' => false,
    ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
       if ($product->delete()) {
            return response()->json(['message' => 'Record is Deleted','change'=>true], 202);
        }
        return response()->json(['message' => 'Failed to delete','change'=>false], 500);
    }
}
