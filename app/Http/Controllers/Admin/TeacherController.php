<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Traits\LogsActivity;
use App\Models\TeacherStaff;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $teachers = TeacherStaff::orderBy('name', 'asc')->get();
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'photo' => 'nullable|string',
            'nip' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $teacher = TeacherStaff::create($validated);

        $this->logActivity('guru', 'create', "Menambah data guru/staf: '{$teacher->name}'");

        return redirect()->route('admin.teachers.index')->with('success', 'Data guru/staf berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $teacher = TeacherStaff::findOrFail($id);
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, $id)
    {
        $teacher = TeacherStaff::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'photo' => 'nullable|string',
            'nip' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $teacher->update($validated);

        $this->logActivity('guru', 'update', "Mengubah data guru/staf: '{$teacher->name}'");

        return redirect()->route('admin.teachers.index')->with('success', 'Data guru/staf berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $teacher = TeacherStaff::findOrFail($id);
        $name = $teacher->name;
        $teacher->delete();

        $this->logActivity('guru', 'delete', "Menghapus data guru/staf: '{$name}'");

        return redirect()->route('admin.teachers.index')->with('success', 'Data guru/staf berhasil dihapus!');
    }

    // Aliases for backward compatibility
    public function teacherIndex() { return $this->index(); }
    public function teacherCreate() { return $this->create(); }
    public function teacherStore(Request $request) { return $this->store($request); }
    public function teacherEdit($id) { return $this->edit($id); }
    public function teacherUpdate(Request $request, $id) { return $this->update($request, $id); }
    public function teacherDelete($id) { return $this->destroy($id); }
}
