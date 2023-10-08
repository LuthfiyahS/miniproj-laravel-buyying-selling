<?php

namespace App\Http\Controllers;

use App\Exports\ExportSales;
use App\Models\Inventory;
use App\Models\Sales;
use App\Models\SalesDetail;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (auth()->user()->role == "Sales" ){
                $data = Sales::where('user_id',auth()->user()->id)->get();
                $jmltransaksi = Sales::where('user_id',auth()->user()->id)->count();
                $totaltransaksi = SalesDetail::join('sales','sales.id','sales_details.sales_id')->where('sales.user_id',auth()->user()->id)->sum('sales_details.price');
                $totalqty = SalesDetail::join('sales','sales.id','sales_details.sales_id')->where('sales.user_id',auth()->user()->id)->sum('qty');
            }elseif (auth()->user()->role == "SuperAdmin" || auth()->user()->role == "Manager" ) {
                $data = Sales::all();
                $jmltransaksi = Sales::count();
                $totaltransaksi = SalesDetail::sum('price');
                $totalqty = SalesDetail::sum('qty');
            }else{
                //return view('error.401');
                return redirect('/dashboard');
            }
            // $data = Sales::all();
            // $jmltransaksi = Sales::count();
            // $totaltransaksi = SalesDetail::sum('price');
            // $totalqty = SalesDetail::sum('qty');
            $sisabayar = 0;
            return view('sales.index',compact('data','jmltransaksi','totaltransaksi','sisabayar','totalqty'));
        } catch (\Exception $e) {
            echo $e->getMessage();
            //return redirect('/dashboard')->with('error',  'Halaman tidak dapat di akses! ');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->role == "Sales" || auth()->user()->role == "SuperAdmin" ){
            $inventory = Inventory::all();
        }else{
            //return view('error.401');
            return redirect('/dashboard');
        }
        
        return view('sales.add', compact('inventory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            if (auth()->user()->role == "Sales" || auth()->user()->role == "SuperAdmin" ){
                $cek = Sales::orderby('id', 'DESC')->first();
            if ($cek) {
                $kodeakhir5 = substr($cek->number, -5);
            } else {
                $kodeakhir5 = 0;
            }

            $kodeku = (int)$kodeakhir5;
            $addNol = '';
            $kodetb = 'SLS';
            $kode = (int)$kodeku + 1;

            if (strlen($kode) == 1) {
                $addNol = "0000";
            } elseif (strlen($kode) == 2) {
                $addNol = "000";
            } elseif (strlen($kode) == 3) {
                $addNol = "00";
            } elseif (strlen($kode) == 4) {
                $addNol = "0";
            } elseif (strlen($kode) == 5) {
                $addNol = "";
            }
            $no_transaksi = $kodetb . now()->format('y') . $addNol . $kode;
            $file = $request->file('file');
            
            Sales::create([
                'number' => $no_transaksi,
                'date' => now(),
                'user_id' => auth()->user()->id,
            ]);
            //convert pembayaran
            
            $detaillenght = count($request->produk_id);
            
            $data = Sales::orderby('id', 'DESC')->first();
            for ($i = 0; $i < $detaillenght; $i++) {
                # code... detail penjualan

                //menambahkan detail ke akun barang
                $detailbarang = Inventory::find($request->produk_id[$i]);
                
                
                //cek bayar
                //masuk insert
                SalesDetail::create([
                    'sales_id' => $data->id,
                    'inventory_id' => $request->produk_id[$i],
                    'price' => $detailbarang->price,
                    'qty' => $request->kuantitas[$i],
                ]);

                //menambahkan detail ke akun barang
                Inventory::where("id", $detailbarang->id)->update([
                    'stock' => $detailbarang->stock - $request->kuantitas[$i], //stok berkurang (karena jual)
                ]);

            }
            Alert::success('Success!', 'Data insert successfully');
            return redirect('/sales')->with('success',  'Data berhasil ditambah! ');
            }else{
                //return view('error.401');
                return redirect('/dashboard');
            }
        }catch(\Exception $e){
            echo $e->getMessage();
            //return redirect('/sales')->with('error',  'Halaman tidak dapat di akses! ');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            if (auth()->user()->role == "Sales" || auth()->user()->role == "SuperAdmin" || auth()->user()->role == "Manager" ){
                $data = Sales::find($id);
                $datadetail = SalesDetail::where('sales_id', $id)->get();
                $totalprice = SalesDetail::where('sales_id', $id)->sum('price');
                $totalqty = SalesDetail::where('sales_id', $id)->sum('qty');
                $totaltag = $totalprice * $totalqty;
                return view('sales.detail', compact('data', 'datadetail','totalprice', 'totalqty','totaltag'));
            }else{
                //return view('error.401');
                return redirect('/dashboard');
            }
            
            
        } catch (\Exception $e) {
            return redirect('/sales')->with('error',  'Halaman tidak dapat di akses! ');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            if (auth()->user()->role == "Sales" || auth()->user()->role == "SuperAdmin"){
                $data = Sales::find($id);
                $datadetail = SalesDetail::where('sales_id', $id)->get();
                $totalprice = SalesDetail::where('sales_id', $id)->sum('price');
                $totalqty = SalesDetail::where('sales_id', $id)->sum('qty');
                $totaltag = $totalprice * $totalqty;
                $barang = Inventory::all();
                $user = User::all();
                return view('sales.edit', compact('data', 'datadetail','barang','user', 'totalprice', 'totalqty','totaltag'));
            }else{
                //return view('error.401');
                return redirect('/dashboard');
            }
            
        } catch (\Exception $e) {
            echo $e->getMessage();
            //return redirect('/sales')->with('error',  'Halaman tidak dapat di akses! ');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Sales::find($id);
            //menambahkan pembayaran ke saldo barang
            $detailsales = SalesDetail::where('sales_id', $id)->get();
            $countbarang = SalesDetail::where('sales_id', $id)->count();
            $detaillenght = count($request->produk_id);
            $bayardidetail = 0;
            Sales::where("id", $id)->update([
                'user_id' => $request->user_id,
            ]);
            for ($i=0; $i < $countbarang ; $i++) {
                
                $detailbarang = Inventory::find($request->produk_id[$i]);
                SalesDetail::where("id", $detailsales[$i]->id)->update([
                    'inventory_id' => $request->produk_id[$i],
                    'price' => $detailbarang->price,
                    'qty' => $request->kuantitas[$i],
                    'updated_at' => now(),
                ]);
                //menambahkan detail ke akun barang
                Inventory::where("id", $detailsales[$i]->id)->update([
                    'stock' => $detailbarang->stock + $detailsales[$i]->qty - $request->kuantitas[$i] , //stok kembali dulu terus berkurang (karena jual)
                ]);
            }
            if ($detaillenght > $countbarang) {
                for ($i = $countbarang; $i < $detaillenght; $i++) {
                    # code... detail penjualan
    
                    //menambahkan detail ke akun barang
                    $detailbarang = Inventory::find($request->produk_id[$i]);
                    
                    //cek bayar
                    //masuk insert
                    SalesDetail::create([
                        'sales_id' => $id,
                        'inventory_id' => $request->produk_id[$i],
                        'price' => $detailbarang->price,
                        'qty' => $request->kuantitas[$i],
                    ]);
    
                    //menambahkan detail ke akun barang
                    Inventory::where("id", $detailbarang->id)->update([
                        'stock' => $detailbarang->stock - $request->kuantitas[$i], //stok berkurang (karena jual)
                    ]);
    
                }
            }
            Alert::success('Success!', 'Data update successfully');
            return redirect('sales/'.$id)->with('success', 'Data berhasil dibuat!');
        } catch (\Exception $e) {
            echo $e->getMessage();

            //return redirect('/penjualan')->with('error',  'Halaman tidak dapat di akses! ');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $x = Sales::find($id);
            //back in stock
            $detailsales = SalesDetail::where('sales_id', $id)->get();
            $countbarang = SalesDetail::where('sales_id', $id)->count();
            
            for ($i=0; $i < $countbarang ; $i++) {
                $detailbarang = Inventory::find($detailsales[$i]->inventory_id);
                //menambahkan detail ke akun barang
                Inventory::where("id", $detailbarang->id)->update([
                    'stock' => $detailbarang->stock + $detailsales[$i]->qty 
                ]);
            }
            $x->delete();
            Alert::success('Success!', 'Data deleted successfully');
            return redirect('/sales')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            echo $e->getMessage();
            // Alert::error('Error!', 'Data deleted failed');
            // return redirect('/sales')->with('error',  'Data tidak berhasil dihapus!');
        }
    }

    public function print($id)
    {
        $cetak = Sales::find($id);
        $data  = SalesDetail::where('sales_id', $id)->get();
        $harga = SalesDetail::where('sales_id', $id)->sum('price');
        $kuantitas = SalesDetail::where('sales_id', $id)->sum('qty');
        //return view('sales.invoice', compact('cetak', 'data', 'harga', 'kuantitas'));

            

        $pdf = PDF::loadView('sales.invoice', compact('cetak', 'data', 'harga', 'kuantitas'));

        return $pdf->download('Sales '.$cetak->number.'.pdf');
    }

    public function printtgl($start, $end)
    {
        if ($start and $end) {
            $penjualan = Sales::whereBetween('sales.date', [$start, $end])
                ->get();

            $price = SalesDetail::select('sales.*', 'sales_details.*')
                ->join('sales', 'sales.id', '=', 'sales_details.sales_id')
                ->whereBetween('sales.date', [$start, $end])
                ->sum('sales_details.price');
            $qty = SalesDetail::select('sales.*', 'sales_details.*')
                ->join('sales', 'sales.id', '=', 'sales_details.sales_id')
                ->whereBetween('sales.date', [$start, $end])
                ->sum('sales_details.qty');
            $sumtotal = $price*$qty;

            $pdf = PDF::loadView('sales.laporan', compact('penjualan', 'start', 'sumtotal', 'end'));

            return $pdf->download('Sales '.$start.' hingga '.$end.'.pdf');
            //return view('sales.laporan', compact('penjualan', 'start', 'sumtotal', 'end'));
        }else{
            Alert::error('Error!', 'Data deleted failed');
            return redirect('/sales')->with('error',  'Data tidak berhasil dihapus!');
        }
    }

    public function export() 
    {
        return Excel::download(new ExportSales, 'sales.xlsx');
    }  
}
