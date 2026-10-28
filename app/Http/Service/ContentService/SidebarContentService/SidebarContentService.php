<?php

namespace App\Http\Service\ContentService\SidebarContentService;

use Illuminate\Support\Facades\Auth;

class SidebarContentService
{

    private $auth_service;

    public function __construct($auth_service)
    {

        $this->auth_service = $auth_service;
    }

    public function setAuthService()
    {

        $check_registered_user = User::find($auth_service);

        if (!Auth::check()):
            throw new InvalidArgumentException('Invalid not event a user.');
        endif;

        return $this->auth_service;
    }

    public function getSidebarContent()
    {

        return $this->auth_service;
    }

    public function getRoleBaseSidebarContent()
    {

        if (Auth::check()):
            switch ($this->auth_service['role_id']):

                case 1:
                    return [
                        'dashboard' => 'dashboard',
                        'category'  => 'event.category',
                        'events'    => 'health.events',
                        'reports'   => 'event.reports',
                        'sign_out'  => 'logout'
                    ];
                    break;

                case 2:
                    return [];
                    break;

                case 3:
                    return [];
                    break;

            endswitch;
        endif;
    }
}
