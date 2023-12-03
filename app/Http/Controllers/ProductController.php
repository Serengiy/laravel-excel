<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportStoreRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Jobs\ImportProjectFromExcelJob;
use App\Models\File;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        return inertia('Product/Index');
    }

    public function getProducts()
    {
        return response()->json([
            'data' => Product::all()
        ]);
    }

    public function create(?Product $product)
    {
        return inertia('Product/Create', compact('product'));
    }

    public function store(ProductStoreRequest $request)
    {
        $data = $request->validated();
        Product::query()->updateOrCreate([
            'id' => $data['id']
        ], $data);

        return redirect()->route('home');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
           'message' => 'Продукт был удален'
        ]);
    }

    public function import(ImportStoreRequest $request)
    {
        $data = $request->validated();
        $path = File::putAndCreateFile($data['file']);

        ImportProjectFromExcelJob::dispatchSync($path);

        return response()->json([
           'data' => Product::all()
        ]);
    }
}
