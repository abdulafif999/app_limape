<?php

namespace App\Charts;

use App\Models\IndexKriteria;
use App\Models\PenilaianDetail;
use App\Models\PenilaianTim;
use App\Models\TimDetail;
use App\Models\TimUnit;
use App\Models\UnitDetail;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class BarChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): array
    {
        $unitDetail = UnitDetail::with('karyawan', 'timUnit')->get();
        $timList = TimUnit::all('nama')->toArray();
        $timUnit = TimUnit::all()->toArray();
        $penilaianDetail = PenilaianDetail::with('kriteria', 'penilaian')->get();
        $indexKriteria = IndexKriteria::all();
        $timDetail = TimDetail::with('karyawan', 'tim')->get()->toArray();

        $penilaianTim= PenilaianTim::with('tim', 'timUnit')->get()->toArray();

        $bulan_periode = date('m');
        $tahun_periode = date('Y');
        static $daftarTim = [];

        for($i = 0;$i < count($timUnit);$i++){
            $nilai_final = 0;
            $total = [];
            $kategori= [];
            $daftarTim[$i] = $timUnit[$i];
            $daftarTim[$i]->tim = [];
            $a = 0;

            $jumlahAnggota = 0;

            for($j=0; $j < count($penilaianTim); $j++){ 
                for ($k=0; $k < count($timDetail); $k++) { 
                    if($penilaianTim[$j]['tim_id'] == $timDetail[$k]['tim_id'] && $penilaianTim[$j]['tim_unit']['nama'] == $timUnit[$i]['nama']){
                        $jumlahAnggota++;
                        
                    }

                }
            }
            for ($l=0; $l < count($penilaianTim); $l++) { 
                if($penilaianTim[$l]['tim_unit_id'] == $timUnit[$i]['id']){
                    $daftarTim[$i]->tim[$a] = (object)[
                        'nama_tim' => '',
                        'nilai' => [],
                    ];
                    $daftarTim[$i]->tim[$a]->nama_tim = $penilaianTim[$l]->tim->nama;
                    $kategori[$a] = $penilaianTim[$l]['tim']['nama'];
                    $a++;
                }
                


            }
            $daftarTim[$i]['kategori'] = $kategori;
        }
        return $this->chart->barChart()
            ->setTitle('')
            ->addData('Nilai 5P/Unit', [])
            ->setXAxis($timList)
            ->setColors(['#ffc63b', '#ff6384'])
            ->setMarkers(['#FF5722'], 7, 10)
            ->toVue();
    }
}
