<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <meta name="description" content="YOUR DESCRIPTION FOR PROJECT 2">
</head>
<body>
    <!-- The root div where React will render the application -->
    <div id="root"></div>

    <!-- Vite-related Blade directives for hot reloading -->
    @viteReactRefresh
    @vite('resources/js/index.jsx') <!-- Main entry point for React -->
</body>
</html>
