<?php

namespace App\Charts;

use App\Models\Purchase;
use App\Models\Sales;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class TransactionChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $sales = Sales::count();
        $purchase = Purchase::count();
        return $this->chart->pieChart()
            ->setTitle('Purchase and Sales.')
            ->setSubtitle('This Year')
            ->addData([$sales, $purchase])
            ->setLabels(['Sales', 'Purchase']);
    }
}
