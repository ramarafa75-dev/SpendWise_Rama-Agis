<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', '=', Auth::id(), 'and')->get();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'max_budget' => 'required|numeric|min:0',
        ]);

        Category::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'max_budget' => $request->max_budget,
        ]);

        return redirect()->route('categories.index')
                         ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function destroy(Category $category)
    {
        Category::destroy($category->id);
        return redirect()->route('categories.index')
                         ->with('success', 'Kategori berhasil dihapus!');
    }
}