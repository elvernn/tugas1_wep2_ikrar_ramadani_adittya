<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    public function index()
    {
        $dosen = Lecturer::orderBy('id', 'desc')->paginate(5);
        return view('lecturers.index', compact('dosen'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('lecturers.create');
    }

    public function store(Request $request)
    {
        // lakukan validasi untuk setiap request yang dikirim
        $request->validate([
            'nip' => 'required|max:8',
            'nama' => 'required|max:30',
            'keilmuan' => 'required|max:30',
        ]);
        // lakukan create/insert data ke tabel database
        $dosen = Lecturer::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'keilmuan' => $request->keilmuan,
        ]);
        // bisa juga langsung menggunakan request all untuk create data
        // $dosen = Lecturer::create($request->all());
        return redirect('/lecturers')->with('success', 'Lecturer created successfully.');
    }

    public function show(string $id)
    {
        // menuju view show.blade.php di folder lecturers dengan membawa data dari pencarian
        $dosen = Lecturer::findOrFail($id);
        return view('lecturers.show', compact('dosen'));
    }

    public function edit(string $id)
    {
        $dosen = Lecturer::findOrFail($id);
        return view('lecturers.edit', compact('dosen'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nip' => 'required|max:8',
            'nama' => 'required|max:30',
            'keilmuan' => 'required|max:30',
        ]);
        // Cari data sesuai parameter $id dan lakukan update data tabel dari seluruh request
        $dosen = Lecturer::findOrFail($id);
        $dosen->update($request->all());
        return redirect('/lecturers')->with('success', 'Lecturers updated successfully.');
    }

    public function destroy(string $id)
    {
        $dosen = Lecturer::where('id', $id)->delete();
        return redirect('/lecturers')->with('success', 'Lecturers deleted successfully.');
    }
}
