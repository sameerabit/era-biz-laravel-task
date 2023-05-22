<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Product;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductImageResource;
use App\Http\Requests\UpdateProductImageRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $productQuery = Product::query();
        if ($request->name) {
            $productQuery->where('name', $request->name);
        }
        if ($request->description) {
            $productQuery->orWhere('description', 'like', "%$request->description%");
        }
        if ($request->min_price && $request->max_price) {
            $productQuery->whereBetween('price', [$request->min_price, $request->max_price]);
            $productQuery->orderBy('price', 'ASC');
        }
        $products = $productQuery->paginate();
        return ProductResource::collection($products);
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
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price =  $request->price;
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

    public function updateProductImage(UpdateProductImageRequest $request, $id)
    {
        $image_path = $request->file('image')->store('image', 'products');
        $product = Product::find($id);
        $product->image_url = $image_path;
        $product->save();
        return response(ProductImageResource::make($product), Response::HTTP_CREATED);
    }

    public function getProductImage($id)
    {
        $product = Product::findOrFail($id);
        $image = Storage::disk('products')->get($product->image_url);
        return response($image, 200)->header('Content-Type', Storage::disk('products')->mimeType($product->image_url));
    }
}
