<?php

namespace App\Http\Controllers;

use App\Charts\BarChart;
use App\Charts\LineChart;
use App\Charts\NilaiChart;
use App\Charts\RankingChart;
use App\Models\Dashboard;
use App\Models\IndexKriteria;
use App\Models\KategoriHasil;
use App\Models\Penilaian;
use App\Models\PenilaianDetail;
use App\Models\PenilaianTim;
use App\Models\Tim;
use App\Models\TimDetail;
use App\Models\TimUnit;
use App\Models\UnitDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
public function index(NilaiChart $penilaianChart, LineChart $rankingChart)
    {
        $penilaianDetail = PenilaianDetail::with('kriteria', 'penilaian')->get();
        $penilaian = Penilaian::with('karyawan', 'timUnit')->get();
        $approved = Penilaian::where('approve', '=' , true)->with('karyawan', 'timUnit')->get();
        $timUnit = UnitDetail::with('timUnit', 'karyawan')->get();
        $tim = TimDetail::with('karyawan', 'tim')->get();
        $timlist = TimUnit::orderBy('nama', 'asc')->get();
        $timPenilai = Tim::all();
        $penilaianTim = PenilaianTim::with('tim', 'timUnit')->get();
        $indexKriterias = IndexKriteria::all();
        $kategoriHasil = KategoriHasil::all();
        $user = Auth::user()->pernum;
        $role = Auth::user()->role;
        

        return Inertia::render('Dashboard', [
            'penilaians' => $penilaian,
            'penilaianDetails' => $penilaianDetail,
            'penilaianChart' => $penilaianChart->build(),
            'tims' => $tim,
            'timUnits' => $timUnit,
            'timList' => $timlist,
            'timPenilai' => $timPenilai,
            'penilaianTims' => $penilaianTim,
            'indexKriterias' => $indexKriterias,
            'rankingChart' => $rankingChart->build(),
            'kategoriHasil' => $kategoriHasil,
            'currentUser' => $user,
            'role' => $role,
            'approvedPenilaians' => $approved,

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function show(Dashboard $dashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }
}
