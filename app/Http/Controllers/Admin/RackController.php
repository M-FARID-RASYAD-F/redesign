<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Rack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RackController extends Controller
{
    protected function logActivity(string $action, string $description): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'module' => 'rak_buku',
            'action' => $action,
            'description' => $description,
        ]);
    }

    public function index()
    {
        $racks = Rack::withCount('books')->orderBy('code', 'asc')->get();
        return view('admin.racks.index', compact('racks'));
    }

    public function create()
    {
        return view('admin.racks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:racks,code',
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $rack = Rack::create($validated);

        $this->logActivity('create', "Menambah rak buku: '{$rack->code} - {$rack->name}'");

        return redirect()->route('admin.racks.index')->with('success', 'Rak buku berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $rack = Rack::findOrFail($id);
        return view('admin.racks.edit', compact('rack'));
    }

    public function update(Request $request, $id)
    {
        $rack = Rack::findOrFail($id);

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', Rule::unique('racks')->ignore($rack->id)],
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $rack->update($validated);

        $this->logActivity('update', "Mengubah rak buku: '{$rack->code} - {$rack->name}'");

        return redirect()->route('admin.racks.index')->with('success', 'Rak buku berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $rack = Rack::findOrFail($id);
        $code = $rack->code;
        $name = $rack->name;
        $rack->delete();

        $this->logActivity('delete', "Menghapus rak buku: '{$code} - {$name}'");

        return redirect()->route('admin.racks.index')->with('success', 'Rak buku berhasil dihapus!');
    }
}
