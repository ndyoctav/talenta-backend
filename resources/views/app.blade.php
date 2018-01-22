<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Talenta To Do</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>

    <body>
        <div class="container">
            <nav class="navbar navbar-default">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">
                        Talenta
                    </a>
                </div>
            </nav>
        </div>

        @yield('content')
        
        <script>
            @yield('script')
        </script>
    </body>
</html>
