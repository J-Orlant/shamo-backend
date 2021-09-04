<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function all(Request $request)
    {
        $id  = $request->input('id');
        $limit  = $request->input('limit');
        $name  = $request->input('name');
        $show_products  = $request->input('show_products');


        if ($id) {
            $category = ProductCategory::with(['products'])->find($id);

            if ($category) {
                return ResponseFormatter::success(
                    $category,
                    'Data Kategori Berhasil di Ambil',
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data Kategori Tidak Ada',
                    404,
                );
            }
        }

        $category = ProductCategory::query();

        if ($name) {
            $category->where('name', 'Like', '%' . $name . '%');
        }

        if ($show_products) {
            $category->with('products');
        }

        return ResponseFormatter::success(
            $category->paginate($limit),
            'Data Kategori berhasil diambil',
        );
    }
}
