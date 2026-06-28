<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Administración - Blog Cristiano</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Scripts & Styles -->
        @viteReactRefresh
        @vite(['resources/css/app.css', 'resources/js/admin.jsx'])
        @inertiaHead
        
        <style>
            body {
                font-family: 'Outfit', sans-serif;
                background-color: #0f172a; /* Slate 900 */
                color: #f8fafc;
                margin: 0;
            }
        </style>
    </head>
    <body>
        @inertia
    </body>
</html>
