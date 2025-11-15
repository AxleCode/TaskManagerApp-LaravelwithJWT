@extends('layouts.app')

@section('content')
<h3>Welcome, {{ $user->name }} ({{ $user->role ? 'Admin' : 'User' }})</h3>

@if($user->role)
<h4>All Users</h4>
<table class="table table-bordered">
    <thead>
        <tr><th>Name</th><th>Email</th><th>Role</th></tr>
    </thead>
    <tbody>
        @foreach($users as $u)
        <tr>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->role ? 'Admin' : 'User' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

<h4 class="mt-4">Tasks</h4>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            @if($user->role)<th>Assigned To</th><th>Actions</th>@endif
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
        <tr>
            <td>{{ $task->title }}</td>
            <td>{{ $task->description }}</td>
            <td>{{ ['Pending','In Progress','Done'][$task->status] }}</td>
            @if($user->role)
            <td>{{ $task->assignedUser?->name ?? '-' }}</td>
            <td>
                <a href="{{ route('tasks.edit',$task->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('tasks.destroy',$task->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                </form>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>

<h4 class="mt-4">Task Status Chart</h4>
<canvas id="taskChart"></canvas>
@endsection

@push('scripts')
<script>
const ctx = document.getElementById('taskChart').getContext('2d');
const taskChart = new Chart(ctx, {
    type:'bar',
    data:{
        labels:['Pending','In Progress','Done'],
        datasets:[{
            label:'Number of Tasks',
            data:[
                {{ $taskStats[0] ?? 0 }},
                {{ $taskStats[1] ?? 0 }},
                {{ $taskStats[2] ?? 0 }}
            ],
            backgroundColor:['#f39c12','#3498db','#2ecc71']
        }]
    },
    options:{responsive:true}
});
</script>
@endpush
