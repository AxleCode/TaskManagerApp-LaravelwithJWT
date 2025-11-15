<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Task Manager App</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body { background-color:#f8f9fa; }
    .sidebar { min-height:100vh; background:#343a40; color:#fff; }
    .sidebar a { color:#fff; text-decoration:none; display:block; padding:10px; }
    .sidebar a:hover { background:#495057; }
    .content { padding:20px; }
</style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar p-3">
        <h4>Task Manager</h4>
        <hr>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        @if(auth()->user()->role == 1)
        <a href="{{ route('tasks.index') }}">All Tasks</a>
        <a href="{{ route('tasks.create') }}">Create Task</a>
        @else
        <a href="{{ route('tasks.my') }}">My Tasks</a>
        @endif
        <form action="{{ route('logout') }}" method="POST" class="mt-3">
            @csrf
            <button type="submit" class="btn btn-danger w-100">Logout</button>
        </form>
    </div>

    <!-- Main content -->
    <div class="flex-grow-1 content">
        @yield('content')
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@stack('scripts')
</body>
</html>
