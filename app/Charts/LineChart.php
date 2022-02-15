<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class LineChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): array
    {
        return $this->chart->lineChart()
            ->setTitle('')
            ->setSubtitle('')
            ->addData('', [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0])
            ->setXAxis(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'])
            ->toVue();
    }
}
