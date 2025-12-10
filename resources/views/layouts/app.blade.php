<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Migraine Screening</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('screenings.create') }}">Clinical Trial Screening</a>
        <div class="navbar-nav">
            <a class="nav-link" href="{{ route('screenings.create') }}">New Screening</a>
            <a class="nav-link" href="{{ route('screenings.index') }}">All Screenings</a>
        </div>
    </div>
</nav>

<div class="container">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
