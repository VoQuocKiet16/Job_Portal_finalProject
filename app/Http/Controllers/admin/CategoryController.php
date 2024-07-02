<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::orderBy('created_at','DESC')->paginate(10);
        return view('admin.category.list',[
            'categories' => $categories
        ]);
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function saveCategroy(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = new Category;
        $category->name = $request->name;
        $category->save();

        return redirect()->route('admin.categories')->with('success', 'Category created successfully.');
    }

    public function delete(Request $request) {
        $id = $request->id;

        $category = Category::find($id);

        if($category == null){
            session()->flash('error', 'Cateogry not found');
            return response()->json([
                'status' => false,
                
            ]);
        }

        $category->delete();
        session()->flash('success', 'Category deleted successfully');
        return response()->json([
            'status' => true,

        ]);
    }
}
