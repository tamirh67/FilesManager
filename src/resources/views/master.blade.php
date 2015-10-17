<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tasks</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    @yield('styles')
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Tasks</a>
        </div>
        <div class="nav navbar-nav navbar-right">
            <li><a href="/ex1">ex1</a></li>
            <li><a href="/ex2">ex2</a></li>
            <li><a href="/ex1form">ex1 upload</a></li>
            <li><a href="/ex2form">ex2 upload</a></li>
        </div>
    </div>
</nav>

<main>
    <div class="container">
        @yield('content')
    </div>
</main>
    @yield('scripts')
</body>
</html>