<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard() { return view('dashboard'); }

    // News
    public function newsIndex() { return response(''); }
    public function newsCreate() { return response(''); }
    public function newsStore(Request $request) { return response(''); }
    public function newsEdit($id) { return response(''); }
    public function newsUpdate(Request $request, $id) { return response(''); }
    public function newsDelete($id) { return response(''); }

    // Teachers
    public function teacherIndex() { return response(''); }
    public function teacherCreate() { return response(''); }
    public function teacherStore(Request $request) { return response(''); }
    public function teacherEdit($id) { return response(''); }
    public function teacherUpdate(Request $request, $id) { return response(''); }
    public function teacherDelete($id) { return response(''); }

    // Majors
    public function majorIndex() { return response(''); }
    public function majorCreate() { return response(''); }
    public function majorStore(Request $request) { return response(''); }
    public function majorEdit($id) { return response(''); }
    public function majorUpdate(Request $request, $id) { return response(''); }
    public function majorDelete($id) { return response(''); }

    // PPDB
    public function ppdbIndex() { return response(''); }
    public function ppdbShow($id) { return response(''); }
    public function ppdbUpdateStatus(Request $request, $id) { return response(''); }
    public function ppdbDelete($id) { return response(''); }
}
