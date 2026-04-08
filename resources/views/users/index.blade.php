<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1e1e2f;
            color: #f8f9fa;
        }

        .card {
            background-color: #2c2c3e;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        }

        h2 {
            font-weight: 700;
            font-size: 2rem;
            text-align: center;
            background: linear-gradient(90deg, #ff6ec4, #7873f5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .table {
            color: #f8f9fa;
        }

        .table thead {
            background-color: #3a3a4f;
        }

        .btn {
            border-radius: 8px;
        }

        .badge {
            font-size: 0.9rem;
        }

        .container {
            max-width: 900px;
        }
    </style>
</head>

<body>
    <div class="container my-5 d-flex justify-content-center">
        <div class="card w-100 p-4 shadow-lg">

            <h2 class="mb-4">User Management</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="d-flex flex-column flex-md-row justify-content-between mb-3 gap-2">
                <form method="GET" action="{{ route('users.index') }}" class="d-flex flex-grow-1 gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Search by name or email">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
                <div class="d-flex gap-2">
                    <a href="{{ route('users.export') }}" class="btn btn-success">Export CSV</a>
                    <a href="{{ route('users.trash') }}" class="btn btn-danger">Trash Users</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge {{ $user->status ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $user->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="d-flex gap-2 justify-content-center">
                                    <form method="POST" action="{{ route('users.toggle', $user->id) }}">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-warning btn-sm">Toggle</button>
                                    </form>

                                    <form method="POST" action="{{ route('users.destroy', $user->id) }}">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">{{ $users->links() }}</div>
        </div>
    </div>
</body>

</html>