<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\ActivityLog;
use App\Models\Tool;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToolController extends Controller
{
    public function index()
    {
        $Tool  = Tool::all();
        return view('Admin.Tool.index', compact('Tool'));
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
        ]);

        Tool::create($request->all());

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity'  => "Menambahkan alat: {$request->name}"
        ]);

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
        ]);

        $tool->update($request->all());

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity'  => "Memperbarui alat: {$request->name}"
        ]);

        return redirect()->route('admin.tools.index')->with('success', 'Data alat berhasil diperbarui!');
    }

    public function destroy(Tool $tool)
    {
        $tool->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity'  => "Menghapus alat: {$tool->name}"
        ]);

        return redirect()->route('admin.tools.index')->with('success', 'Data alat berhasil dihapus!');
    }
}
