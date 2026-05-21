<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function __construct()
    {
        // Only authenticated users can access
        $this->middleware('auth');
    }

    /**
     * Display users with search
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search by name or email
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(4);

        return view('users.index', compact('users'));
    }

    /**
     * Toggle user status
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        $user->status = !$user->status;

        $user->save();

        return back()->with('success', 'User status updated successfully!');
    }

    /**
     * Soft delete user
     */
    public function destroy($id)
    {
        // Prevent deleting own account
        if (auth()->id() == $id) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        $user = User::findOrFail($id);

        $user->delete();

        return back()->with('success', 'User moved to trash successfully!');
    }

    /**
     * Show trashed users
     */
    public function trash()
    {
        $users = User::onlyTrashed()
                    ->latest()
                    ->paginate(10);

        return view('users.trash', compact('users'));
    }

    /**
     * Restore trashed user
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        $user->restore();

        return back()->with('success', 'User restored successfully!');
    }

    /**
     * Permanently delete user
     */
    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        $user->forceDelete();

        return back()->with('success', 'User permanently deleted!');
    }

    /**
     * Export users CSV
     */
    public function export()
    {
        $users = User::all();

        $fileName = 'users.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ];

        $columns = [
            'ID',
            'Name',
            'Email',
            'Status',
        ];

        $callback = function () use ($users, $columns) {

            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, $columns);

            // Data rows
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
}
