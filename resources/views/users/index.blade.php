<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, #4f46e5 0%, transparent 30%),
                radial-gradient(circle at bottom right, #9333ea 0%, transparent 30%),
                #0f172a;
            font-family: 'Segoe UI', sans-serif;
            color: white;
        }

        .main-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 25px;
            padding: 35px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        }

        .page-title {
            font-size: 2.6rem;
            font-weight: 800;
            margin-bottom: 30px;
            background: linear-gradient(to right, #38bdf8, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-control {
            height: 55px;
            border: none;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.08);
            color: white;
            padding-left: 18px;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.12);
            color: white;
            box-shadow: none;
            border: 1px solid #8b5cf6;
        }

        .form-control::placeholder {
            color: #cbd5e1;
        }

        .btn-custom {
            border: none;
            border-radius: 14px;
            padding: 12px 22px;
            font-weight: 600;
            transition: 0.3s;
            color: white;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            opacity: 0.95;
            color: white;
        }

        .btn-search {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        }

        .btn-export {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .btn-trash {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .btn-toggle {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            padding: 8px 18px;
            border-radius: 10px;
            font-size: 14px;
            color: white;
            border: none;
        }

        .btn-delete {
            background: linear-gradient(135deg, #dc2626, #991b1b);
            padding: 8px 18px;
            border-radius: 10px;
            font-size: 14px;
            color: white;
            border: none;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .custom-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 18px;
        }

        .custom-table thead th {
            border: none;
            color: #94a3b8;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 1px;
            padding-bottom: 15px;
        }

        .custom-table tbody tr {
            background: rgba(15, 23, 42, 0.92);
            transition: 0.3s ease;
        }

        .custom-table tbody tr:hover {
            transform: scale(1.01);
            background: rgba(30, 41, 59, 1);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
        }

        .custom-table td {
            padding: 22px 18px;
            border: none;
            vertical-align: middle;
            color: #f8fafc !important;
            font-size: 15px;
        }

        .custom-table tbody tr td:first-child {
            border-radius: 18px 0 0 18px;
        }

        .custom-table tbody tr td:last-child {
            border-radius: 0 18px 18px 0;
        }

        .user-name {
            font-weight: 700;
            color: #ffffff;
        }

        .user-email {
            color: #cbd5e1;
        }

        .badge-status {
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
        }

        .active-status {
            background: rgba(16, 185, 129, 0.18);
            color: #34d399;
        }

        .inactive-status {
            background: rgba(148, 163, 184, 0.18);
            color: #cbd5e1;
        }

        .alert {
            border-radius: 14px;
            border: none;
        }

        /* Pagination */

        .custom-pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

        .custom-pagination {
            display: flex;
            align-items: center;
            gap: 12px;
            list-style: none;
            padding: 0;
        }

        .custom-pagination li a,
        .custom-pagination li span {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 700;
            font-size: 15px;
            transition: 0.3s ease;
        }

        .custom-pagination li a {
            background: rgba(255, 255, 255, 0.08);
            color: #e2e8f0;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .custom-pagination li a:hover {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            transform: translateY(-3px);
            color: white;
        }

        .custom-pagination li.active span {
            background: linear-gradient(135deg, #8b5cf6, #6366f1);
            color: white;
            box-shadow: 0 5px 20px rgba(139, 92, 246, 0.5);
        }

        .custom-pagination li.disabled span {
            background: rgba(255, 255, 255, 0.04);
            color: #64748b;
            cursor: not-allowed;
        }

        @media(max-width:768px) {

            .page-title {
                font-size: 2rem;
            }

            .top-actions {
                flex-direction: column;
            }

            .btn-custom {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="container py-5">

        <div class="main-card">

            <h1 class="page-title text-center">
                User Management
            </h1>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="d-flex justify-content-between gap-3 mb-4 top-actions flex-wrap">

                <form method="GET"
                    action="{{ route('users.index') }}"
                    class="d-flex gap-2 flex-grow-1">

                    <input type="text"
                        name="search"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="Search by name or email...">

                    <button class="btn btn-custom btn-search">
                        Search
                    </button>

                </form>

                <div class="d-flex gap-2 flex-wrap">

                    <a href="{{ route('users.export') }}"
                        class="btn btn-custom btn-export">

                        Export CSV

                    </a>

                    <a href="{{ route('users.trash') }}"
                        class="btn btn-custom btn-trash">

                        Trash Users

                    </a>

                </div>

            </div>

            <div class="table-wrapper">

                <table class="custom-table">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>USER</th>
                            <th>EMAIL</th>
                            <th>STATUS</th>
                            <th class="text-center">ACTIONS</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($users as $user)

                            <tr>

                                <td>#{{ $user->id }}</td>

                                <td class="user-name">
                                    {{ $user->name }}
                                </td>

                                <td class="user-email">
                                    {{ $user->email }}
                                </td>

                                <td>

                                    @if($user->status)

                                        <span class="badge-status active-status">
                                            Active
                                        </span>

                                    @else

                                        <span class="badge-status inactive-status">
                                            Inactive
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <div class="d-flex justify-content-center gap-2">

                                        <form method="POST"
                                            action="{{ route('users.toggle', $user->id) }}">

                                            @csrf
                                            @method('PATCH')

                                            <button class="btn btn-toggle">
                                                Toggle
                                            </button>

                                        </form>

                                        <form method="POST"
                                            action="{{ route('users.destroy', $user->id) }}">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-delete"
                                                onclick="return confirm('Delete this user?')">

                                                Delete

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center py-4">
                                    No Users Found
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Custom Pagination --}}
            <div class="custom-pagination-wrapper">

                @if ($users->hasPages())

                    <ul class="custom-pagination">

                        {{-- Previous --}}
                        @if ($users->onFirstPage())

                            <li class="disabled">
                                <span>‹</span>
                            </li>

                        @else

                            <li>
                                <a href="{{ $users->previousPageUrl() }}">‹</a>
                            </li>

                        @endif

                        {{-- Page Numbers --}}
                        @for ($i = 1; $i <= $users->lastPage(); $i++)

                            @if ($i == $users->currentPage())

                                <li class="active">
                                    <span>{{ $i }}</span>
                                </li>

                            @else

                                <li>
                                    <a href="{{ $users->url($i) }}">{{ $i }}</a>
                                </li>

                            @endif

                        @endfor

                        {{-- Next --}}
                        @if ($users->hasMorePages())

                            <li>
                                <a href="{{ $users->nextPageUrl() }}">›</a>
                            </li>

                        @else

                            <li class="disabled">
                                <span>›</span>
                            </li>

                        @endif

                    </ul>

                @endif

            </div>

        </div>

    </div>

</body>

</html>
