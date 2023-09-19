<?php

namespace App\Http\Controllers;

use App\Models\Gelombang;
use App\Models\gelombang_prodi;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KuotaProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $prodi = Prodi::all();
        foreach ($prodi as $value) {
            $value->kuota = $value->gelombang_prodi->where('gelombang_id', $request->gelombang_id)->first() ? $value->gelombang_prodi->where('gelombang_id', $request->gelombang_id)->first()->kuota : 0;
        }
        $gelombang = Gelombang::find($request->gelombang_id);
        return view('pages.kuota_prodi', compact('prodi', 'gelombang'));
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
        DB::beginTransaction();
        try {
            $gelombang = Gelombang::find($request->gelombang_id);
            $current_kuota = $gelombang->current_kuota - $request->kuota;
            if($current_kuota < 0){
                return back()->withErrors("Kuota yang dimasukkan terlalu besar dan melebihi kuota yang ada saat ini, mohon isi ulang kuota!");
            }
            $kuota_prodi = gelombang_prodi::where([['gelombang_id', $request->gelombang_id], ['prodi_id', $request->prodi_id]])->first();
            if (!$kuota_prodi) {
                $kuota_prodi = new gelombang_prodi();
                $kuota_prodi->gelombang_id = $request->gelombang_id;
                $kuota_prodi->prodi_id = $request->prodi_id;
            }
            $kuota_prodi->kuota = $request->kuota;
            $kuota_prodi->save();

            $gelombang = Gelombang::find($request->gelombang_id);
            $gelombang->current_kuota = $gelombang->kuota - $gelombang->gelombang_prodi->sum('kuota');
            $gelombang->save();     
            DB::commit();
            return redirect()->route('kuota_prodi.index', ['gelombang_id'=>$request->gelombang_id])->with('success', 'Berhasil set kuota prodi');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('toast_error', $th->getMessage());
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
