<?php

namespace App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Service\ContentService\SidebarContentService\SidebarContentService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Enums\Event\Categories;
//maps
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;


class DashboardController extends Controller{

    public function dashboard(){

        return Inertia::render('Dashboard');

    }

    public function category(){
        return Inertia::render('Admin/Category/Index/Category',[
            'categories' => Categories::cases()
        ]);
    }

    public function events(){

        return Inertia::render('Admin/Events/Index/Event',[
            'places'  => [],
            'center'  => [14.52899, 121.06998],
            'zoom'    => 15
        ]);

    }

    public function reports(){
        return Inertia::render('Admin/Reports/Report');
    }

}
