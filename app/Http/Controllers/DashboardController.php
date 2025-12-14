<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            return $this->adminDashboard();
        }
        
        return $this->userDashboard();
    }

    // User Home - Product Catalog
    public function home()
    {
        $query = Product::where('stock', '>', 0);
        
        if (request('category')) {
            $query->where('category_id', request('category'));
        }
        
        if (request('search')) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . request('search') . '%')
                  ->orWhere('description', 'like', '%' . request('search') . '%');
            });
        }
        
        $products = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::withCount('products')->get();

        return view('user.home', compact('products', 'categories'));
    }

    private function adminDashboard()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_users' => User::where('role', 'user')->count(),
            'total_transactions' => Transaction::count(),
            'pending_payments' => Transaction::where('status', 'pending')->count(),
            'processing_payments' => Transaction::where('status', 'processing')->count(),
            'completed_transactions' => Transaction::where('status', 'completed')->count(),
            'total_revenue' => Transaction::where('status', 'completed')->sum('total_amount'),
            'today_revenue' => Transaction::where('status', 'completed')->whereDate('created_at', today())->sum('total_amount'),
            'pending_transactions' => Transaction::with('user')->where('status', 'pending')->latest()->take(10)->get(),
            'awaiting_confirmation' => Transaction::with('user')->where('status', 'processing')->latest()->take(10)->get(),
            'recent_transactions' => Transaction::with('user')->latest()->take(5)->get(),
            'low_stock_products' => Product::lowStock()->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    private function userDashboard()
    {
        $user = auth()->user();
        $recent_transactions = $user->transactions()->latest()->take(5)->get();
        $unread_notifications = $user->notifications()->unread()->count();

        return view('user.dashboard', compact('user', 'recent_transactions', 'unread_notifications'));
    }
}