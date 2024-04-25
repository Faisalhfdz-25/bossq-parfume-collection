<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = User::query();

            return DataTables::of($query)
                ->addColumn('action', function ($user) {
                    return '
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editUserModal' . $user->id . '">
                            Edit
                        </button>
                        <form action="' . route('user.destroy', $user->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm delete-user" data-user-id="' . $user->id . '">Delete</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make();
        }

        $users = User::all(); // Menyediakan data pengguna untuk view
        return view('pages.user.index', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:15',
            'role' => 'required|string|in:admin,user'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        User::create($request->all());
    
        return redirect()->route('user.index')->with('success', 'User created successfully!');
    }
    
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
            'phone' => 'required|string|max:15',
            'role' => 'required|string|in:admin,user'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Hapus password dari request jika tidak diisi
        if (!$request->filled('password')) {
            $request->request->remove('password');
        }
    
        $user->update($request->all());
    
        return redirect()->route('user.index')->with('success', 'User updated successfully!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    // Redirect back to user index page with success message
    return redirect()->route('user.index')->with('success', 'User deleted successfully!');
}
}
