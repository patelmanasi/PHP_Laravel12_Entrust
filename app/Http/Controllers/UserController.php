<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Only logged-in users
    }

    // List users + search
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }

        $users = $query->paginate(10);

        return view('users.index', compact('users'));
    }

    // Toggle status
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = !$user->status;
        $user->save();

        return back()->with('success', 'User status updated!');
    }

    // Soft delete user
    public function destroy($id)
    {
        if (auth()->id() == $id) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'User deleted!');
    }

    // Export CSV
    public function export()
    {
        $users = User::all();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users.csv"',
        ];

        $columns = ['ID', 'Name', 'Email', 'Status'];

        $callback = function () use ($users, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->status ? 'Active' : 'Inactive',
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    // Trash users
    public function trash()
    {
        $users = User::onlyTrashed()->paginate(10);
        return view('users.trash', compact('users'));
    }

    // Restore user
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        return back()->with('success', 'User restored!');
    }

    // Permanently delete
    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();
        return back()->with('success', 'User permanently deleted!');
    }
}