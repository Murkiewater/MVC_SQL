<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>demo</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; }
        .card { border: 1px solid #ddd; margin-bottom: 12px; border-radius: 6px; }
        a { color: #1a73e8; text-decoration: none; }
    </style>
</head>
<body>
    <h1>demo app</h1>
    <nav>
        <a href="{{ route('users.index') }}">Users</a> |
        <a href="{{ route('groups.index') }}">Groups</a> |
        <a href="{{ route('post-in-groups.index') }}">Posts</a>
    </nav>
    <hr>
    @yield('content')
</body>