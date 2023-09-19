<?php

namespace App\Http\Controllers;

use App\Models\Gelombang;
use App\Models\gelombang_prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WisudaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gelombang = Gelombang::orderby('id', 'desc')->get();
        $count = $gelombang->count();
        foreach($gelombang as $value){
            $value->gel = $count;
            $count--;
        }
        return view('pages.wisuda', compact('gelombang'));
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
        $count_wisuda = Gelombang::get()->count();
        $gelombang = new Gelombang();
        $gelombang->nama = $count_wisuda + 1;
        $gelombang->tanggal_wisuda = $request->date;
        $gelombang->jenis = $request->jenis;
        $gelombang->kuota = $request->kuota;
        $gelombang->current_kuota = $request->kuota;
        $gelombang->save();

        return redirect()->route('wisuda.index')->with('success', 'Berhasil menambahkan gelombang wisuda baru');
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
        $gelombang = Gelombang::find($id);
        return view('pages.edit_wisuda', compact('gelombang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $gelombang = Gelombang::find($id);
            $gelombang->jenis = $request->jenis;
            $gelombang->tanggal_wisuda = $request->date;
            if($gelombang->kuota != $request->kuota){
                $gelombang->kuota = $request->kuota;
                $gelombang->current_kuota = $request->kuota;
                $relasi = gelombang_prodi::where('gelombang_id', $gelombang->id)->get();
                foreach($relasi as $value){
                    $value->kuota = 0;
                    $value->save();
                }
            }
            $gelombang->save();
            DB::commit();
            return redirect()->route('wisuda.index')->with('success', 'Berhasil update data wisuda');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('toast_error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
