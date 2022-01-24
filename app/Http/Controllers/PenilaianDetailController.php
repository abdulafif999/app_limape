<?php

namespace App\Http\Controllers;

use App\Charts\BarChart;
use App\Charts\PenilaianDetailChart;
use App\Models\Image;
use App\Models\Kriteria;
use App\Models\Nilai;
use App\Models\Penilaian;
use App\Models\PenilaianDetail;
use App\Models\User;
use Hamcrest\Core\HasToString;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PenilaianDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kriteria = Kriteria::orderBy('nama', 'asc')->orderBy('sub_kriteria', 'asc')->get();
        $data = PenilaianDetail::with('penilaian','kriteria')->get();
        $dataPenilians = Penilaian::with('karyawan','timUnit')->get();
        $nilais = Nilai::with('kriteria')->get();
        $pernum = Auth::user()->pernum;
        return Inertia::render('Penilaian/Partials/CreatePenilaianDetail', [
            'penilaianDetails' => $data, 
            'kriterias' => $kriteria,
            'penilaians' => $request,
            'dataPenilaians' =>$dataPenilians,
            'nilais' => $nilais,
            'pernum' => $pernum,

        ]);
        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pernum = Auth::user()->pernum;
        
        $request->validate([
            'nilai.*' => 'required|integer|min:0|max:100',
            'status.*' => 'nullable',
            'rekomendasi.*' => 'nullable',
            'foto.*' => 'nullable'
        ]);
        
        $picture = $request->file('foto');

        $penilaian = $request->penilaian_id;
        $kriteria = $request->kriteria;
        $nilai = $request->nilai;
        $status = $request->status;
        $rekomendasi = $request->rekomendasi;
        $n = 0;
            foreach ($kriteria as $row) {
                PenilaianDetail::create([
                    'penilaian_id' => $penilaian,
                    'kriteria_id' => $row,
                    'nilai' => $nilai[$n],
                    'status' => $status[$n],
                    'rekomendasi' => $rekomendasi[$n],
                    'foto' => '',
                ]);
                $n++;
            }
        return redirect()->route('penilaian.index')->with('message', 'Data Berhasil Ditambah.');;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PenilaianDetail  $penilaianDetail
     * @return \Illuminate\Http\Response
     */
    public function show(PenilaianDetail $penilaianDetail, Request $request, BarChart $chartPenilaian)
    {

    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\PenilaianDetail  $penilaianDetail
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(PenilaianDetail $penilaianDetail)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PenilaianDetail  $penilaianDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $penilaianDetail = PenilaianDetail::findOrFail($id);
        $penilaianDetail->nilai = $request->nilai;
        $penilaianDetail->status = $request->status;
        $penilaianDetail->rekomendasi = $request->rekomendasi;
        $penilaianDetail->foto = $request->foto;
        $penilaianDetail->save();

        return redirect()->back();
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\PenilaianDetail  $penilaianDetail
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(PenilaianDetail $penilaianDetail)
    // {
    //     //
    // }
}
