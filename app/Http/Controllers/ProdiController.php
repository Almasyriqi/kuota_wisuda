<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $jurusan = Jurusan::findOrFail($request->jurusan_id);
        $prodi = Prodi::where('jurusan_id', $request->jurusan_id)->get();
        return view('pages.prodi', compact('jurusan', 'prodi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'jenjang' => 'required'
        ]);
    
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $prodi = new Prodi();
        $nama = $request->jenjang . " " . $request->nama;
        $prodi->jurusan_id = $request->jurusan_id;
        $prodi->nama = strtoupper($nama);
        $prodi->jenjang = $request->jenjang;
        $prodi->save();

        return redirect()->route('prodi.index', ['jurusan_id' => $request->jurusan_id])->with('success', 'Berhasil menambahkan prodi baru');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $prodi = Prodi::find($id);
        $nama = str_replace($prodi->jenjang, "", $prodi->nama);
        return response()->json(['nama_prodi' => $nama, 'jenjang' => $prodi->jenjang]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'edit_nama' => 'required|string',
            'jenjang' => 'required'
        ]);
    
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $prodi = Prodi::find($id);
        $nama = $request->jenjang . " " . $request->edit_nama;
        $prodi->jurusan_id = $request->jurusan_id;
        $prodi->nama = strtoupper($nama);
        $prodi->jenjang = $request->jenjang;
        $prodi->save();

        return redirect()->route('prodi.index', ['jurusan_id' => $request->jurusan_id])->with('success', 'Berhasil update prodi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
