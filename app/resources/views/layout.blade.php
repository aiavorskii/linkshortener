<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Linkshortener</title>
        <link rel="stylesheet" href="/css/app.css">

    </head>
    <body class="antialiased">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @yield('content')
                </div>
            </div>
        </div>
        <script src="/app.js"></script>
        @yield('modals')
    </body>
</html>
