<?php

namespace App\Http\Controllers;

use App\Exports\ExportPurchase;
use App\Models\Inventory;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (auth()->user()->role == "Purchase" ){
                $data = Purchase::where('user_id',auth()->user()->id)->get();
                $jmltransaksi = Purchase::where('user_id',auth()->user()->id)->count();
                $totaltransaksi = PurchaseDetail::join('purchases','purchases.id','purchase_details.purchase_id')->where('purchases.user_id',auth()->user()->id)->sum('purchase_details.price');
                $totalqty = PurchaseDetail::join('purchases','purchases.id','purchase_details.purchase_id')->where('purchases.user_id',auth()->user()->id)->sum('qty');
            }elseif (auth()->user()->role == "SuperAdmin" || auth()->user()->role == "Manager" ) {
                $data = Purchase::all();
                $jmltransaksi = Purchase::count();
                $totaltransaksi = PurchaseDetail::sum('price');
                $totalqty = PurchaseDetail::sum('qty');
            }else{
                //return view('error.401');
                return redirect('/dashboard');
            }
            // $data = Purchase::all();
            // $jmltransaksi = Purchase::count();
            // $totaltransaksi = PurchaseDetail::sum('price');
            // $totalqty = PurchaseDetail::sum('qty');
            $sisabayar = 0;
            return view('purchase.index',compact('data','jmltransaksi','totaltransaksi','sisabayar','totalqty'));
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
        if (auth()->user()->role == "Purchase" || auth()->user()->role == "SuperAdmin" ){
            $inventory = Inventory::all();
        }else{
            //return view('error.401');
            return redirect('/dashboard');
        }
        
        return view('purchase.add', compact('inventory'));
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
            if (auth()->user()->role == "Purchase" || auth()->user()->role == "SuperAdmin" ){
                $cek = Purchase::orderby('id', 'DESC')->first();
            if ($cek) {
                $kodeakhir5 = substr($cek->number, -5);
            } else {
                $kodeakhir5 = 0;
            }

            $kodeku = (int)$kodeakhir5;
            $addNol = '';
            $kodetb = 'PRC';
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
            
            Purchase::create([
                'number' => $no_transaksi,
                'date' => now(),
                'user_id' => auth()->user()->id,
            ]);
            //convert pembayaran
            
            $detaillenght = count($request->produk_id);
            
            $data = Purchase::orderby('id', 'DESC')->first();
            for ($i = 0; $i < $detaillenght; $i++) {
                # code... detail penjualan

                //menambahkan detail ke akun barang
                $detailbarang = Inventory::find($request->produk_id[$i]);
                
                
                //cek bayar
                //masuk insert
                PurchaseDetail::create([
                    'purchase_id' => $data->id,
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
            return redirect('/purchase')->with('success',  'Data berhasil ditambah! ');
            }else{
                //return view('error.401');
                return redirect('/dashboard');
            }
        }catch(\Exception $e){
            echo $e->getMessage();
            //return redirect('/purchase')->with('error',  'Halaman tidak dapat di akses! ');
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
            if (auth()->user()->role == "Purchase" || auth()->user()->role == "SuperAdmin" || auth()->user()->role == "Manager" ){
                $data = Purchase::find($id);
                $datadetail = PurchaseDetail::where('purchase_id', $id)->get();
                $totalprice = PurchaseDetail::where('purchase_id', $id)->sum('price');
                $totalqty = PurchaseDetail::where('purchase_id', $id)->sum('qty');
                $totaltag = $totalprice * $totalqty;
                return view('purchase.detail', compact('data', 'datadetail','totalprice', 'totalqty','totaltag'));
            }else{
                //return view('error.401');
                return redirect('/dashboard');
            }
            
            
        } catch (\Exception $e) {
            return redirect('/purchase')->with('error',  'Halaman tidak dapat di akses! ');
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
            if (auth()->user()->role == "Purchase" || auth()->user()->role == "SuperAdmin"){
                $data = Purchase::find($id);
                $datadetail = PurchaseDetail::where('purchase_id', $id)->get();
                $totalprice = PurchaseDetail::where('purchase_id', $id)->sum('price');
                $totalqty = PurchaseDetail::where('purchase_id', $id)->sum('qty');
                $totaltag = $totalprice * $totalqty;
                $barang = Inventory::all();
                $user = User::all();
                return view('purchase.edit', compact('data', 'datadetail','barang','user', 'totalprice', 'totalqty','totaltag'));
            }else{
                //return view('error.401');
                return redirect('/dashboard');
            }
            
        } catch (\Exception $e) {
            echo $e->getMessage();
            //return redirect('/purchase')->with('error',  'Halaman tidak dapat di akses! ');
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
            $data = Purchase::find($id);
            //menambahkan pembayaran ke saldo barang
            $detailpurchase = PurchaseDetail::where('purchase_id', $id)->get();
            $countbarang = PurchaseDetail::where('purchase_id', $id)->count();
            $detaillenght = count($request->produk_id);
            $bayardidetail = 0;
            Purchase::where("id", $id)->update([
                'user_id' => $request->user_id,
            ]);
            for ($i=0; $i < $countbarang ; $i++) {
                
                $detailbarang = Inventory::find($request->produk_id[$i]);
                PurchaseDetail::where("id", $detailpurchase[$i]->id)->update([
                    'inventory_id' => $request->produk_id[$i],
                    'price' => $detailbarang->price,
                    'qty' => $request->kuantitas[$i],
                    'updated_at' => now(),
                ]);
                //menambahkan detail ke akun barang
                Inventory::where("id", $detailpurchase[$i]->id)->update([
                    'stock' => $detailbarang->stock + $detailpurchase[$i]->qty - $request->kuantitas[$i] , //stok kembali dulu terus berkurang (karena jual)
                ]);
            }
            if ($detaillenght > $countbarang) {
                for ($i = $countbarang; $i < $detaillenght; $i++) {
                    # code... detail penjualan
    
                    //menambahkan detail ke akun barang
                    $detailbarang = Inventory::find($request->produk_id[$i]);
                    
                    //cek bayar
                    //masuk insert
                    PurchaseDetail::create([
                        'purchase_id' => $id,
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
            return redirect('purchase/'.$id)->with('success', 'Data berhasil dibuat!');
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
            $x = Purchase::find($id);
            //back in stock
            $detailpurchase = PurchaseDetail::where('purchase_id', $id)->get();
            $countbarang = PurchaseDetail::where('purchase_id', $id)->count();
            
            for ($i=0; $i < $countbarang ; $i++) {
                $detailbarang = Inventory::find($detailpurchase[$i]->inventory_id);
                //menambahkan detail ke akun barang
                Inventory::where("id", $detailbarang->id)->update([
                    'stock' => $detailbarang->stock + $detailpurchase[$i]->qty 
                ]);
            }
            $x->delete();
            Alert::success('Success!', 'Data deleted successfully');
            return redirect('/purchase')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            echo $e->getMessage();
            // Alert::error('Error!', 'Data deleted failed');
            // return redirect('/purchase')->with('error',  'Data tidak berhasil dihapus!');
        }
    }

    public function print($id)
    {
        $cetak = Purchase::find($id);
        $data  = PurchaseDetail::where('purchase_id', $id)->get();
        $harga = PurchaseDetail::where('purchase_id', $id)->sum('price');
        $kuantitas = PurchaseDetail::where('purchase_id', $id)->sum('qty');
        //return view('purchase.invoice', compact('cetak', 'data', 'harga', 'kuantitas'));

            

        $pdf = PDF::loadView('purchase.invoice', compact('cetak', 'data', 'harga', 'kuantitas'));

        return $pdf->download('Purchase '.$cetak->number.'.pdf');
    }

    public function printtgl($start, $end)
    {
        if ($start and $end) {
            $penjualan = Purchase::whereBetween('purchase.date', [$start, $end])
                ->get();

            $price = PurchaseDetail::select('purchase.*', 'purchase_details.*')
                ->join('purchase', 'purchases.id', '=', 'purchase_details.purchase_id')
                ->whereBetween('purchase.date', [$start, $end])
                ->sum('purchase_details.price');
            $qty = PurchaseDetail::select('purchase.*', 'purchase_details.*')
                ->join('purchase', 'purchases.id', '=', 'purchase_details.purchase_id')
                ->whereBetween('purchase.date', [$start, $end])
                ->sum('purchase_details.qty');
            $sumtotal = $price*$qty;

            $pdf = PDF::loadView('purchase.laporan', compact('penjualan', 'start', 'sumtotal', 'end'));

            return $pdf->download('Purchase '.$start.' hingga '.$end.'.pdf');
            //return view('purchase.laporan', compact('penjualan', 'start', 'sumtotal', 'end'));
        }else{
            Alert::error('Error!', 'Data deleted failed');
            return redirect('/purchase')->with('error',  'Data tidak berhasil dihapus!');
        }
    }

    public function export() 
    {
        return Excel::download(new ExportPurchase, 'purchase.xlsx');
    }  
}
