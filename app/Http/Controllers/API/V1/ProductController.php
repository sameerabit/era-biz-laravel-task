<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Product;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductResource::collection(Product::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $image_path = $request->file('image')->store('image', 'products');
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_url' => $image_path
        ]);

        return response(ProductResource::make($product), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return ProductResource::make($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // $image_path = $request->file('image')->store('image', 'products');
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price =  $request->price;
        // $product->image_url = $image_path;
        $product->save();
        $product->flush();
        return response(ProductResource::make($product), Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->noContent();
    }

    public function updateProductImage($id)
    {
        $image = Storage::disk('products')->get($path);
        return response($image, 200)->header('Content-Type', Storage::getMimeType($path));
    }

    public function getProductImage($path)
    {
        $image = Storage::disk('products')->get($path);
        return response($image, 200)->header('Content-Type', Storage::getMimeType($path));
    }
}
