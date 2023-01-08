<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request) {
        if($request->id) {
            $product = Product::where('id', $request->id)->with(['category', 'galeries'])->first();

            if($product) {
                return ResponseFormatter::success($product, 'Data product berhasil diambil');
            } else {
                return ResponseFormatter::error(null, 'Data product tidak ada', 404);
            }
        }

        $product = Product::with(['category', 'galeries']);
        
        if($request->name) {
            $product->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if($request->description) {
            $product->where('description', 'LIKE', '%' . $request->description . '%');
        }

        if($request->tags) {
            $product->where('tags', 'LIKE', '%' . $request->tags . '%');
        }

        if($request->input('price_from')) {
            $product->where('price_from', '>=', $request->price_from);
        }

        if($request->price_from) {
            $product->where('price_from', '>=', $request->price_from);
        }

        if($request->price_to) {
            $product->where('price_to', '<=', $request->price_to);
        }

        if($request->category) {
            $product->where('category', $request->category);
        }

        return ResponseFormatter::success($product->paginate($request->limit), 'Data product berhasil diambil');
    }
}
