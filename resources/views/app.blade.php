<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
         
        <!-- Sets the browser tab's title using your Laravel app name. The inertia attribute allows Inertia to update the title dynamically for different pages. -->
        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->

        @routes <!-- Generates JavaScript route information using Ziggy, allowing Vue to access your named Laravel routes. -->

       <!-- Loads your JavaScript entry point and the Vue component for the requested page. For example, if the component is Dashboard, it loads Dashboard.vue.-->
   
       @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])

        <!-- Allows Inertia to manage page-specific HTML head elements, such as the title and meta tags.
            
        ex: <Head title="Log in" />
        -->
        @inertiaHead
    </head>
    <body class="font-sans antialiased">

         <!-- Creates the mount point where Inertia renders your Vue page.-->
        @inertia
    </body>
</html>
