<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request) {
        $id = $request->input('id');
        $name = $request->input('name');
        $show_product = $request->input('show_product');
        $limit = $request->input('limit');
        
        if($id) {
            $category = Category::where('id', $id)->with(['products'])->first();

            if($category) {
                return ResponseFormatter::success($category, 'Data category berhasil diambil');
            } else {
                return ResponseFormatter::error(null, 'Data category tidak ada', 404);
            }
        }

        $category = Category::query();
        
        if($name) {
            $category->where('name', 'like', '%' . $name . '%');
        }

        if($show_product) {
            $category->with('products');
        }

        return ResponseFormatter::success($category->paginate($limit), 'Data list category berhasil diambil');
    }
}
