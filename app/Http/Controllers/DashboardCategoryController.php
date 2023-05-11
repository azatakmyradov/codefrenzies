<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        return Inertia::render('Dashboard/Categories/Index', [
            'categories' => Category::latest('id')->get()
        ]);
    }

    public function store(CategoryRequest $request)
    {
        $attributes = $request->validated();

        $category = Category::create($attributes);

        return back()->with('message', 'Category was created!');
    }

    public function destroy(Category $category)
    {
        try {
            $category->deleteOrFail();
        } catch (\Throwable $e) {
            return back()->with('error', 'This category cannot be deleted');
        }

        return back()->with('message', 'Category was deleted!');
    }
}
