@extends('layouts.app')
@section('content')
<h3>Create Task</h3>
<form action="{{ route('tasks.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <input type="text" name="title" class="form-control" placeholder="Title" required>
    </div>
    <div class="mb-3">
        <textarea name="description" class="form-control" placeholder="Description"></textarea>
    </div>
    @if(auth()->user()->role == 1)
    <div class="mb-3">
        <select name="assigned_to" class="form-control">
            <option value="">-- Assign to user --</option>
            @foreach($users as $u)
            <option value="{{ $u->id }}">{{ $u->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <select name="status" class="form-control">
            <option value="0">Pending</option>
            <option value="1">In Progress</option>
            <option value="2">Done</option>
        </select>
    </div>
    @endif
    <button class="btn btn-success">Create</button>
</form>
@endsection
