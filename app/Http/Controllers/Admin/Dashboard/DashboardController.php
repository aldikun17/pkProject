<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Service\ContentService\SidebarContentService\SidebarContentService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Enums\Event\Categories;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
//maps
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;


class DashboardController extends Controller
{

    public function dashboard()
    {

        return Inertia::render('Dashboard');
    }

    public function category()
    {
        $event_categories = Category::latest()->paginate(10);

        return Inertia::render('Admin/Category/Index/Category', [
            'categories' => Categories::cases(),
            "event_categories" => $event_categories
        ]);
    }

    public function events()
    {

        return Inertia::render('Admin/Events/Index/Event', [
            'places'  => [],
            'center'  => [14.52899, 121.06998],
            'zoom'    => 15
        ]);
    }

    public function reports()
    {
        return Inertia::render('Admin/Reports/Report');
    }
}
