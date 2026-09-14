<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Traits\LogsActivity;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MajorController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $majors = Major::orderBy('name', 'asc')->get();
        return view('admin.majors.index', compact('majors'));
    }

    public function create()
    {
        return view('admin.majors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $major = Major::create($validated);

        $this->logActivity('jurusan', 'create', "Menambah jurusan baru: '{$major->name}'");

        return redirect()->route('admin.majors.index')->with('success', 'Jurusan baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $major = Major::findOrFail($id);
        return view('admin.majors.edit', compact('major'));
    }

    public function update(Request $request, $id)
    {
        $major = Major::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
        ]);

        if ($major->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $major->update($validated);

        $this->logActivity('jurusan', 'update', "Mengubah jurusan: '{$major->name}'");

        return redirect()->route('admin.majors.index')->with('success', 'Data jurusan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $major = Major::findOrFail($id);
        $name = $major->name;
        $major->delete();

        $this->logActivity('jurusan', 'delete', "Menghapus jurusan: '{$name}'");

        return redirect()->route('admin.majors.index')->with('success', 'Jurusan berhasil dihapus!');
    }

    // Aliases for backward compatibility
    public function majorIndex() { return $this->index(); }
    public function majorCreate() { return $this->create(); }
    public function majorStore(Request $request) { return $this->store($request); }
    public function majorEdit($id) { return $this->edit($id); }
    public function majorUpdate(Request $request, $id) { return $this->update($request, $id); }
    public function majorDelete($id) { return $this->destroy($id); }
}
