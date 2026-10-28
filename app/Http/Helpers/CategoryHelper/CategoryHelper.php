<?php

namespace App\Http\Helpers\CategoryHelper;

use App\Models\Category;

class CategoryHelper
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function CreateUpdateCategories($id = null)
    {
        Category::updateOrCreate(
            ["id" => $id],
            [
                "category_name" => $this->request["category_name"],
                "category_description" => $this->request["category_description"]
            ]
        );
    }
}
