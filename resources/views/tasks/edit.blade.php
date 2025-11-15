@extends('layouts.app')
@section('content')
<h3>Edit Task</h3>
<form action="{{ route('tasks.update',$task->id) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
        <input type="text" name="title" class="form-control" placeholder="Title" value="{{ old('title',$task->title) }}" required>
    </div>
    <div class="mb-3">
        <textarea name="description" class="form-control" placeholder="Description">{{ old('description',$task->description) }}</textarea>
    </div>
    @if(auth()->user()->role == 1)
    <div class="mb-3">
        <select name="assigned_to" class="form-control">
            <option value="">-- Assign to user --</option>
            @foreach($users as $u)
            <option value="{{ $u->id }}" {{ $task->assigned_to==$u->id?'selected':'' }}>{{ $u->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <select name="status" class="form-control">
            <option value="0" {{ $task->status==0?'selected':'' }}>Pending</option>
            <option value="1" {{ $task->status==1?'selected':'' }}>In Progress</option>
            <option value="2" {{ $task->status==2?'selected':'' }}>Done</option>
        </select>
    </div>
    @endif
    <button class="btn btn-primary">Update</button>
</form>
@endsection
