<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

/*
     HandleInertiaRequests.php sets $rootView = 'app', telling Inertia to use app.blade.php as the root HTML template for your Vue application.

     This file handles the data Laravel shares with your frontend and identifies the root Blade template.

     This tells Inertia to use the app.blade.php file as its root HTML template when a page is first loaded.
     For example, if you visit /dashboard, Laravel uses app.blade.php to load the initial HTML page.
*/

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     * This tells Inertia to use the app.blade.php file as its root HTML template when a page is first loaded.
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     * Inertia’s version() detects frontend asset changes after deployment and reloads the page when versions differ, ensuring users receive the latest Vue and CSS files.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     * This shares the currently authenticated user with your Inertia pages.
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
        ];


        /*

         The share() method makes common data, like the authenticated user's name and email, available across Inertia Vue pages without manually passing it from every controller.

        Without share(), Vue cannot access $page.props.auth.user automatically. You must pass the user data from your controller or share it through middleware.
        */
    }
}
