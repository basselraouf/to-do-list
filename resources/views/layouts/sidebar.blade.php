<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', config('app.name', 'Laravel'))</title>
    </head>
    <body>
        <div class="wrapper">
            <!-- Sidebar  -->
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h3>To-Do-List APPLICATION</h3>
                </div>

                <ul class="list-unstyled components">
                    <li>
                        <a href="home">Home</a>
                    </li>
                    @role('admin')
                    <li>
                        <a href="admin-panel">Admin Panel</a>
                    </li>
                    @endrole
                </ul>
            </nav>

            <!-- Page Content  -->
            <div id="content">
    </body>
</html>
