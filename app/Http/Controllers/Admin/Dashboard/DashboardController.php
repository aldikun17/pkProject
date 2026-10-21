<?php

namespace App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Service\ContentService\SidebarContentService\SidebarContentService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class DashboardController extends Controller{

    protected function contentService($auth){

        return new SidebarContentService($auth);

    }

    public function dashboard(){

        $sidebarContent = $this->contentService(Auth::user());
        return Inertia::render('Dashboard',[
            'content' => $sidebarContent->getRoleBaseSidebarContent()
        ]);

    }
}
