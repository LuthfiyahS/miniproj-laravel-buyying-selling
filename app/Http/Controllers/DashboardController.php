<?php

namespace App\Http\Controllers;

use App\Charts\TransactionChart;
use App\Models\Inventory;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Sales;
use App\Models\SalesDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(TransactionChart $chart)
    {
        try {
            $chart = $chart->build();
            $kasmasuk = 1000;
            $kaskeluar = 100;
            $totalpenjualan = SalesDetail::sum('price');
            $totalpembelian = PurchaseDetail::sum('price');
            $pembelian = Sales::count();
            $penjualan = Purchase::count();
            
            $barang = Inventory::orderBy('id', 'DESC')->limit(4)->get();

            // $pembelian_chart = Pembelian::select(DB::raw('count(id) as `data`'), DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
            // ->groupBy('year','month')
            // ->where('year',date("Y"))
            // ->where('jenis_transaksi', 'pembelian')
            // ->get();
            $pembelian_chart = Purchase::select(DB::raw('count(id) as `data`'), DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
            ->groupBy('year','month')
            ->get();
            $penjualan_chart = Sales::select(DB::raw('count(id) as `data`'),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
            ->groupby('year','month')
            ->get();

            //echo $pembelian_chart;
            return view('dashboard',compact('pembelian','penjualan','barang','penjualan_chart','pembelian_chart','totalpenjualan', 'totalpembelian','kasmasuk','kaskeluar','chart'));
        } catch (QueryException $e) {
            return redirect('/dashboard')->with('error',  'Halaman tidak dapat di akses! ');
        }
    }
}
