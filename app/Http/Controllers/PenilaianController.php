<?php

namespace App\Http\Controllers;


use App\Models\Penilaian;
use App\Models\TimDetail;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\PenilaianDetailController;
use App\Models\IndexKriteria;
use App\Models\Karyawan;
use App\Models\PenilaianDetail;
use App\Models\PenilaianTim;
use App\Models\Tim;
use App\Models\TimUnit;
use App\Models\UnitDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */    
    public function index(Request $request)
    {   

        $tims = TimDetail::with('tim','karyawan')->get();
        $indexKriteras = IndexKriteria::all();
        $timList = Tim::all();
        $penilaianTims = PenilaianTim::with('tim', 'timUnit')->get();
        $data = Penilaian::when($request->input('term'), function($query, $term){
            $query->where('tim_unit_id', 'LIKE', '%'.$term.'%');
        })->when($request->input('periode'), function($query, $termPeriod){
            $termPeriod = Carbon::parse($termPeriod);
            $query->whereDate('periode', '=', $termPeriod->format('y-m-d'));
        })->with('karyawan', 'timUnit')->get();

        $penilaian = Penilaian::when($request->input('allTerm'), function($query, $term){
            $query->where('tim_unit_id', 'LIKE', '%'.$term.'%');
        })->when($request->input('allPeriode'), function($query, $termPeriod){
            $termPeriod = Carbon::parse($termPeriod);
            $query->whereDate('periode', '=', $termPeriod->format('y-m-d'));
        })->with('karyawan', 'timUnit')->get();
        
        // $data = Penilaian::when($request->term, function($query, $term){
        //     $query->where('tim_unit_id', 'LIKE', $term);
        // })->with('karyawan', 'timUnit')->get();
        // $periode = $request->input('periode');
        // $data->when($periode, function($query, $termPeriod){
        //     $termPeriod = Carbon::parse($termPeriod);
        //     $query->whereDate('periode', '=', $termPeriod->format('y-m-d'));
        // });
        $timUnit = TimUnit::orderBy('nama', 'asc')->get();
        $dataDetail = PenilaianDetail::with('kriteria','penilaian')->get();
        $unitDetails = UnitDetail::with('timUnit','karyawan')->get();
        $pernum = Auth::user()->pernum;
        $role = Auth::user()->role;
        $filter = TimDetail::all('nip')->toArray();
        $karyawan = Karyawan::whereIn('nip', $filter)->get();


        return Inertia::render('Penilaian/Index', [
            'penilaians' => $data, 
            'tims' => $tims,
            'timList' => $timList,
            'timUnits' => $timUnit,
            'penilaianDetails' => $dataDetail,
            'penilaianTims' => $penilaianTims,
            'unitDetails' => $unitDetails,
            'pernum' => $pernum,
            'role' => $role,
            'term' =>$request->term,
            'periode'=>$request->periode,
            'allTerm' =>$request->allTerm,
            'allPeriode'=>$request->allPeriode,
            'karyawans' => $karyawan,
            'indexKriterias' => $indexKriteras,
            'allPenilaian' =>$penilaian,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tgl' => 'required|date',
            'pernum' => 'required',
            'tim_unit_id' => 'required',
            'periode' => 'required',
            
        ]);                
        $penilaian = new Penilaian();
        $penilaian->tgl = $request->tgl;
        $penilaian->pernum = $request->pernum;
        $penilaian->tim_unit_id= $request->tim_unit_id;
        $penilaian->periode= $request->periode;

        $penilaian->save();

        return redirect()->route('penilaianDetail.index', [
            'penilaian_id' => $penilaian->id, 
            'pernum' => $penilaian->pernum, 
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function show(Penilaian $penilaian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function edit(Penilaian $penilaian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penilaian $penilaian)
    {
        $approve = $request->penilaian_id;
        foreach ($approve as $key) {
            $values = [
                'approve' => true
            ];
            $update = Penilaian::where('id', '=', $key);
            $update->update($values);
        };

        return redirect()->back()->with('message', 'Data berhasil di Approv');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penilaian $penilaian)
    {
        //
    }
}
