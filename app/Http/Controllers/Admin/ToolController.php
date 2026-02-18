<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\ActivityLog;
use App\Models\Tool;
use App\Models\Category;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToolController extends Controller
{

    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }


    public function index(Request $request)
    {
        $query = Tool::with('category');

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhereHas('category', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
        }

        // Filter Category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $tools = $query->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('Admin.Tool.index', compact('tools', 'categories'));
    }

    public function create()
    {
        return view('Admin.Tool.create  ', [
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'category_id' => 'required',
            'stock'       => 'required|integer',
            'price_per_day' => 'required|numeric',
            'img'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imgPath = null;
        if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store('tools', 'public');
        }


        Tool::create(array_merge($request->all(), ['img' => $imgPath]));

       $this->activityLogService->log(Auth::id(), "Menambahkan alat: {$request->name}");

        return redirect()->route('admin.tools.index')->with('success', 'Data alat berhasil ditambahkan!');
    }

    public function edit(Tool $tool)
    {
        return view('Admin.Tool.edit', [
            'tool' => $tool,
            'categories' => Category::all()
        ]);
    }

    public function update(Request $request, Tool $tool)
    {
        $request->validate([
            'name'        => 'required',
            'category_id' => 'required',
            'stock'       => 'required|integer',
            'price_per_day' => 'required|numeric',
            'img'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);


        if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store('tools', 'public');
            $tool->img = $imgPath;
        }

        $tool->update(array_merge($request->all(), ['img' => $tool->img]));

        $this->activityLogService->log(Auth::id(), "Memperbarui alat: {$tool->name}");

        return redirect()->route('admin.tools.index')->with('success', 'Data alat berhasil diperbarui!');
    }

    public function destroy(Tool $tool)
    {
        $tool->delete();

        $this->activityLogService->log(Auth::id(), "Menghapus alat: {$tool->name}");

        return redirect()->route('admin.tools.index')->with('success', 'Data alat berhasil dihapus!');
    }
}
