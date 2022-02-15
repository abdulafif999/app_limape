<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class TrendChart
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
            ->addData('', [])
            ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June'])
            ->toVue()
    }
}
