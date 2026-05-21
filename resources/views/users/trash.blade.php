<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trash Users</title>

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

        .btn-custom {
            border: none;
            border-radius: 14px;
            padding: 12px 22px;
            font-weight: 600;
            transition: 0.3s;
            color: white;
            text-decoration: none;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            opacity: 0.95;
            color: white;
        }

        .btn-back {
            background: linear-gradient(135deg, #64748b, #475569);
        }

        .btn-restore {
            background: linear-gradient(135deg, #10b981, #059669);
            padding: 8px 18px;
            border-radius: 10px;
            border: none;
            color: white;
        }

        .btn-delete {
            background: linear-gradient(135deg, #ef4444, #b91c1c);
            padding: 8px 18px;
            border-radius: 10px;
            border: none;
            color: white;
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

        .deleted-date {
            color: #fca5a5;
            font-weight: 600;
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

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

    <div class="container py-5">

        <div class="main-card">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                <h1 class="page-title">
                    Trash Users
                </h1>

                <a href="{{ route('users.index') }}"
                    class="btn btn-custom btn-back">

                    Back To Users

                </a>

            </div>

            {{-- Alerts --}}
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

            {{-- Table --}}
            <div class="table-wrapper">

                <table class="custom-table">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>USER</th>
                            <th>EMAIL</th>
                            <th>DELETED AT</th>
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

                                <td class="deleted-date">
                                    {{ $user->deleted_at }}
                                </td>

                                <td>

                                    <div class="d-flex justify-content-center gap-2 action-buttons">

                                        {{-- Restore --}}
                                        <form method="POST"
                                            action="{{ route('users.restore', $user->id) }}">

                                            @csrf
                                            @method('PATCH')

                                            <button class="btn btn-restore">

                                                Restore

                                            </button>

                                        </form>

                                        {{-- Permanent Delete --}}
                                        <form method="POST"
                                            action="{{ route('users.forceDelete', $user->id) }}">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-delete"
                                                onclick="return confirm('Permanently delete this user?')">

                                                Delete Forever

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center py-4">
                                    No Trashed Users Found
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