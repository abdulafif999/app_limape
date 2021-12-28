<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class RankingChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): array
    {
        return $this->chart->barChart()
            ->setTitle('')
            ->setSubtitle('')
            ->addData('Nilai 5P/Unit', [])
            ->setXAxis([''])
            ->setColors(['#ffc63b', '#ff6384'])
            ->setMarkers(['#FF5722'], 7, 10)
            ->toVue();
    }
}
