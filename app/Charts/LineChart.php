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
            ->addData('Physical sales', [40, 93, 35, 42, 18, 82, 78, 90, 89, 89, 89, 66])
            ->setXAxis(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'])
            ->toVue();
    }
}
