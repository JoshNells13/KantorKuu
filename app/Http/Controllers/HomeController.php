<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured tools (latest 4 tools with stock available)
        $featuredTools = Tool::with('category')
            ->where('stock', '>', 0)
            ->latest()
            ->limit(4)
            ->get();
        
        // Get popular categories for the category chips
        $popularCategories = Category::withCount('tools')
            ->having('tools_count', '>', 0)
            ->orderBy('tools_count', 'desc')
            ->limit(4)
            ->get();
        
        return view('welcome', compact('featuredTools', 'popularCategories'));
    }
}
