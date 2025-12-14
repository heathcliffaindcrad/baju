<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $settings = Setting::getSettings();
        $featuredProducts = Product::where('stock', '>', 0)
            ->latest()
            ->take(8)
            ->get();
        $categories = Category::withCount('products')->get();
        
        return view('welcome', compact('settings', 'featuredProducts', 'categories'));
    }
}
