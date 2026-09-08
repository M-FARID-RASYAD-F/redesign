<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    protected function logActivity($module, $action, $description)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'module' => $module,
            'action' => $action,
            'description' => $description,
        ]);
    }

    public function index()
    {
        $users = User::orderBy('id', 'asc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => ['required', Rule::in(['super_admin', 'admin_cms', 'admin_ppdb', 'editor_akademik'])],
            'is_active' => 'boolean',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => $request->has('is_active'),
        ]);

        $this->logActivity('users', 'create', "Menambahkan pengguna admin baru: '{$user->name}' ({$user->role})");

        return redirect()->route('admin.users.index')->with('success', 'Akun admin berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
            'role' => ['required', Rule::in(['super_admin', 'admin_cms', 'admin_ppdb', 'editor_akademik'])],
            'is_active' => 'boolean',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'is_active' => $request->has('is_active'),
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        $this->logActivity('users', 'update', "Mengubah data pengguna admin: '{$user->name}'");

        return redirect()->route('admin.users.index')->with('success', 'Data akun admin berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $name = $user->name;
        $user->delete();

        $this->logActivity('users', 'delete', "Menghapus akun admin: '{$name}'");

        return redirect()->route('admin.users.index')->with('success', 'Akun admin berhasil dihapus!');
    }
}
