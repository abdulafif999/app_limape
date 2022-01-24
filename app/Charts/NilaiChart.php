<?php

namespace App\Charts;

use App\Models\IndexKriteria;
use App\Models\Karyawan;
use App\Models\PenilaianDetail;
use App\Models\PenilaianTim;
use App\Models\TimDetail;
use App\Models\TimUnit;
use App\Models\UnitDetail;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\Date;
use stdClass;

class NilaiChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): array
    {
        // $timList = TimUnit::pluck('nama')->toArray();
        // $timUnit = TimUnit::all()->toArray();
        // $penilaianDetail = PenilaianDetail::with('kriteria', 'penilaian')->get()->toArray();
        // $indexKriteria = IndexKriteria::all()->toArray();
        // $timDetail = TimDetail::with('karyawan', 'tim')->get()->toArray();
        // $penilaianTim= PenilaianTim::with('tim', 'timUnit')->get()->toArray();

        // $bulan_periode = date('m');
        // $tahun_periode = date('Y');
        // $daftarTim = [];
        // $data = [];

        // for($i = 0;$i < count($timUnit);$i++){
        //     $nilai_final = 0;
        //     $total = [];
        //     $kategori= [];
        //     $daftarTim[$i] = $timUnit[$i];
        //     $daftarTim[$i]['tim'] = [];
        //     $a = 0;

        //     $jumlahAnggota = 0;

        //     for($j=0; $j < count($penilaianTim); $j++){ 
        //         for ($k=0; $k < count($timDetail); $k++) { 
        //             if($penilaianTim[$j]['tim_id'] == $timDetail[$k]['tim_id'] && $penilaianTim[$j]['tim_unit']['id'] == $timUnit[$i]['id']){
        //                 $jumlahAnggota++;
                        
        //             }

        //         }
        //     }
        //     for ($l=0; $l < count($penilaianTim); $l++) { 
        //         if($penilaianTim[$l]['tim_unit_id'] == $timUnit[$i]['id']){
        //             $daftarTim[$i]['tim'[$a]] = (object)[
        //                 'nama_tim' => '',
        //                 'nilai' => [],
        //             ];
        //             $daftarTim[$i]['tim'[$a]]->nama_tim = $penilaianTim[$l]['tim']['nama'];
        //             $kategori[$a] = $penilaianTim[$l]['tim']['nama'];
        //             $w=0;
        //             $x=0;
        //             $kriteria_array = [];
        //             $total_array = [];

        //             for ($m=0; $m < count($penilaianDetail); $m++) { 
        //                 $sub_total = 0;
        //                 $index_temp = 0;
        //                 $kriteria_array[$x] = (object)[
        //                     'sub_nilai' => 0,
        //                     'kriteria' => '',
        //                     'sub_kriteria' => '',
        //                     'tgl' => '',
        //                 ];
        //                 if($penilaianDetail[$m]['penilaian']['tim_unit_id'] == $penilaianTim[$l]['tim_unit_id']){
        //                     for ($n=0; $n < count($timDetail); $n++) { 
        //                         if($penilaianDetail[$m]['penilaian']['pernum'] == $timDetail[$n]['karyawan']['pernum'] && $timDetail[$n]['tim_id'] == $penilaianTim[$l]['tim_id']){
        //                             for ($o=0; $o < count($indexKriteria); $o++) { 
        //                                 $bulan_awal = date('m', strtotime($indexKriteria[$o]['periode_awal']));
        //                                 $bulan_akhir = date('m', strtotime($indexKriteria[$o]['periode_akhir']));
        //                                 $bulan_penilaian = date('m', strtotime($penilaianDetail[$m]['penilaian']['periode']));
        //                                 $tahun_awal = date('Y', strtotime($indexKriteria[$o]['periode_awal']));
        //                                 $tahun_akhir = date('Y', strtotime($indexKriteria[$o]['periode_akhir']));
        //                                 $tahun_penilaian = date('Y', strtotime($penilaianDetail[$m]['penilaian']['periode']));

        //                                 if($bulan_penilaian >= $bulan_awal && $tahun_penilaian >= $tahun_awal && $bulan_penilaian <= $bulan_akhir &&$tahun_penilaian <= $tahun_akhir ){
        //                                     if($indexKriteria[$o]['kriteria'] == $penilaianDetail[$m]['kriteria']['nama'] && $indexKriteria[$o]['sub_kriteria'] == $penilaianDetail[$m]['kriteria']['nama']){
        //                                         $sub_total = $sub_total + $penilaianDetail[$m]['nilai'];
        //                                         $index_temp = $indexKriteria[$o]['index'];
        //                                     }             
        //                                 }

        //                             }

        //                         }
        //                     }
        //                     $kriteria_array[$x]->sub_nilai = ($sub_total/$jumlahAnggota) * $index_temp;
        //                     $kriteria_array[$x]->kriteria = $penilaianDetail[$m]['kriteria']['nama'];
        //                     $kriteria_array[$x]->sub_kriteria = $penilaianDetail[$m]['kriteria']['sub_kriteria'];
        //                     $kriteria_array[$x]->tgl = $penilaianDetail[$m]['penilaian']['periode'];
        //                     $x++;
        //                 }
        //             }

        //             for ($p=0; $p < count($indexKriteria); $p++) { 
        //                 if($indexKriteria[$p]['sub_kriteria'] == ''){
        //                     $total_array[$w] = 0;
        //                     $bulan_awal = date('m', strtotime($indexKriteria[$p]['periode_awal']));
        //                     $bulan_akhir = date('m', strtotime($indexKriteria[$p]['periode_akhir']));
        //                     $tahun_awal = date('Y', strtotime($indexKriteria[$p]['periode_awal']));
        //                     $tahun_akhir = date('Y', strtotime($indexKriteria[$p]['periode_akhir']));
        //                     if($bulan_periode >= $bulan_awal && $tahun_periode >= $tahun_awal && $bulan_periode <= $bulan_akhir && $tahun_periode <= $tahun_akhir){
        //                         for ($q=0; $q < count($kriteria_array); $q++) { 
        //                             $penilaian_bulan = date('m', strtotime($kriteria_array[$q]->tgl));
        //                             $penilaian_tahun = date('Y', strtotime($kriteria_array[$q]->tgl));
        //                             if($indexKriteria[$p]['kriteria'] == $kriteria_array[$q]->kriteria){
        //                                 if($penilaian_bulan >= $bulan_awal && $penilaian_tahun >= $tahun_awal && $penilaian_bulan <= $bulan_akhir && $penilaian_tahun <= $tahun_akhir){
        //                                     $total_array[$w] = $total_array[$w] + $kriteria_array[$q]->sub_nilai;
        //                                 }
        //                             }
        //                         }

        //                         $daftarTim[$i]['tim'[$a]]->nilai[$w] = number_format($total_array[$w], 2);
        //                         $total_array[$w] = $total_array[$w] * $indexKriteria[$p]['index'];
        //                         $w++;
        //                     }

        //                 }
        //             }
        //             $total[$a] = 0;
        //             for ($r=0; $r < count($total_array); $r++) { 
        //                 $total[$a] = number_format($total[$a]+$total_array[$r], 2);
        //             }
        //             $a++;
        //         }
        //     }
        //     for ($s=0; $s < count($total); $s++) { 
        //         $nilai_final = $nilai_final + $total[$s];
        //     }
        //     $daftarTim[$i]['nilai_final'] = number_format($nilai_final/$a, 2);
        //     $daftarTim[$i]['kategori'] = $kategori;
        //     $daftarTim[$i]['series'] = $total;
        //     $data[$i] = number_format($nilai_final/$a, 2);
        // }
        return $this->chart->horizontalBarChart()
            ->setTitle('')
            ->setSubtitle('')
            ->setColors(['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e',
            '#f48024', '#69d2e7'])
            ->addData('Nilai 5P', [])
            ->setXAxis([])
            ->toVue();
    }
}
