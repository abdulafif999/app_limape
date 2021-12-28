<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class NilaiChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): array
    {
        return $this->chart->horizontalBarChart()
            ->setTitle('')
            ->setSubtitle('')
            ->setColors(['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e',
            '#f48024', '#69d2e7'
          ])
            ->addData('', [])
            ->setXAxis([])
            ->toVue();
    }
}
