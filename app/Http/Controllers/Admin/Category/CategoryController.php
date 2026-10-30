<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Helpers\CategoryHelper\CategoryHelper;
use App\Models\Category;
use Inertia\Inertia;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private function event_category_helper($request)
    {
        return new CategoryHelper($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $event_category = $request->validate([
            "category_name" => "required|string|max:64",
            "category_description" => "required|string|max:400"
        ]);

        $category_helper = $this->event_category_helper($event_category);
        $category_helper->CreateUpdateCategories();

        return redirect(route('event.category'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $event_categories = Category::where("id", $id)->first();

        if ($event_categories) {
            return Inertia::render("", ["event_categories" => $event_categories]); //for show specific category
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $event_category = $request->validate([
            "category_name" => "required|string|max:64",
            "category_description" => "required|string|max:400"
        ]);

        $eventCategory = Category::where("id", $id)->first();

        if ($eventCategory) {
            $category_helper = $this->event_category_helper($event_category);
            $category_helper->CreateUpdateCategories($id);
        }
        return redirect(route('event.category'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $eventCategory = Category::where("id", $id)->first();

        if ($eventCategory) {
            $eventCategory->delete();
        }
        return redirect(route('event.category'));
    }
}
