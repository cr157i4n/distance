<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function search(Request $request)
    {
        $query = urldecode($request->input('query'));
    

        $products = Product::all();
    

        $results = [];
    
        foreach ($products as $product) {

            $nameDistance = levenshtein(strtolower($query), strtolower($product->name));

            $results[] = [
                'product' => $product,
                'distance' => $nameDistance
            ];
        }
    

        usort($results, function ($a, $b) {
            return $a['distance'] <=> $b['distance'];
        });
    
        $result = count($results) > 0 ? $results[0] : null;
        return response()->json(['results' => $result]);
    }
    
}
