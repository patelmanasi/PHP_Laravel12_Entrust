<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Trash Users</title>
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

        .container {
            max-width: 900px;
        }

        .alert {
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="container my-5 d-flex justify-content-center">
        <div class="card w-100 p-4 shadow-lg">

            <!-- Gradient Heading -->
            <h2 class="mb-4">Trash Users</h2>

            <!-- Messages -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Back button -->
            <div class="mb-3">
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to Users</a>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Deleted At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->deleted_at }}</td>
                                <td class="d-flex gap-2 justify-content-center">
                                    <form method="POST" action="{{ route('users.restore', $user->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-success btn-sm">Restore</button>
                                    </form>
                                    <form method="POST" action="{{ route('users.forceDelete', $user->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Permanently delete?')">Delete Permanently</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">{{ $users->links() }}</div>
        </div>
    </div>
</body>

</html>