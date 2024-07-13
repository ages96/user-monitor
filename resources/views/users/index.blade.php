@include('layouts.header')
<div class="container">
    <h1>User Records</h1>
    <p>Total User Records: {{ $userCount }}</p>
    <table class="table" id="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Location</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->age }}</td>
                    <td>{{ $user->gender }}</td>
                    <td>{{ $user->location }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>
                        <form action="{{ route('users.destroy', $user->uuid) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@include('layouts.footer')