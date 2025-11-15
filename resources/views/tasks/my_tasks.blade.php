@extends('layouts.app')
@section('content')
<h3>My Tasks</h3>
<a href="{{ route('tasks.create') }}" class="btn btn-success mb-3">Create Task</a>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
        <tr>
            <td>{{ $task->title }}</td>
            <td>{{ $task->description }}</td>
            <td>{{ ['Pending','In Progress','Done'][$task->status] }}</td>
            <td>
                <a href="{{ route('tasks.edit',$task->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('tasks.destroy',$task->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete task?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
