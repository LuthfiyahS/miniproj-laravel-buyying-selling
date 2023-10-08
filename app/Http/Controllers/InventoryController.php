<?php

namespace App\Http\Controllers;

use App\Exports\ExportInventory;
use App\Models\Inventory;
use App\Models\PurchaseDetail;
use App\Models\SalesDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (auth()->user()->role == 'SuperAdmin' || auth()->user()->role == 'Manager') {
                $data = Inventory::all();
                $jmlstok = Inventory::sum('stock');
                $inv = Inventory::count();
                return view('inventory.inventory', [
                    'data' => $data,
                    'jmlstok' => $jmlstok,
                    'inv' => $inv,
                ]);
            }else{
                //return view('error.401');
                return redirect('/dashboard');
            }
            
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $data = DB::table('inventories')->orderby('id','DESC')->first();
            if ($data != null) {
                $kodeakhir = substr($data->code,-3);
            }else{
                $kodeakhir = 0;
            }
            $kodeku= (int)$kodeakhir;
            $addNol = '';
            $kodetb = 'IN';
            $kode = (int)$kodeku + 1;

            if (strlen($kode) == 1) {
                $addNol = "00";
            } elseif (strlen($kode) == 2) {
                $addNol = "0";
            } elseif (strlen($kode) == 3) {
                $addNol = "";
            }
            $code = $kodetb.$addNol.$kode;


            $gambar = $request->file('gambar');

            // Jika upload gambar
            if (file_exists($gambar)) {
                // Upload gambar
                $nama_gambar = time() . "-" . $gambar->getClientOriginalName();
                $namaFolder2 = 'file/inventories';
                $gambar->move($namaFolder2, $nama_gambar);
                $pathPublic2 = $namaFolder2 . "/" . $nama_gambar;
            } else {
                // Jika tidak Upload Gambar
                $pathPublic2 = null;
            }

            //Convert to int
            $jual = preg_replace("/[^0-9]/", "", $request->price);
            $price = (int) $jual;
//echo $code;
            Inventory::create([
                'code' => $code,
                'name' => $request->name,
                //'gambar' => $pathPublic2,
                'price' => $price,
                'stock' => $request->stock,
            ]);
            Alert::success('Success!', 'Data insert successfully');
            return redirect('/inventories')->with('success', 'Data berhasil dibuat!');
        } catch (\Exception $e) {
            echo $e->getMessage();

            //return redirect('/inventories')->with('error',  'Halaman tidak dapat di akses! ');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

            $gambar = $request->file('gambar');

            // Jika upload gambar
            if (file_exists($gambar)) {
                // Upload gambar
                $nama_gambar = time() . "-" . $gambar->getClientOriginalName();
                $namaFolder2 = 'file/inventories';
                $gambar->move($namaFolder2, $nama_gambar);
                $pathPublic2 = $namaFolder2 . "/" . $nama_gambar;

                // Delete gambar
                $data =  Inventory::find($id);
                File::delete($data->gambar);
            } else {
                // Jika tidak Upload Gambar
                $pathPublic2 = $request->pathGambar;
            }

            //Convert to int
            $jual = preg_replace("/[^0-9]/", "", $request->price);
            $price = (int) $jual;

            Inventory::where("id", $id)->update([
                'name' => $request->name,
                //'gambar' => $pathPublic2,
                'price' => $price,
                'stock' => $request->stock,
            ]);
            Alert::success('Success!', 'Data update successfully');
            return redirect('/inventories')->with('success', 'Data berhasil diupdate!');
        } catch (\Exception $e) {
            //echo $e->getMessage();
            return redirect('/inventories')->with('error',  'Halaman tidak dapat di akses! ');
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
            $x = Inventory::find($id);
            // Delete gambar
            File::delete($x->gambar);
            $x->delete();
            Alert::success('Success!', 'Data deleted successfully');
            return redirect('/inventories')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            Alert::error('Error!', 'Data deleted failed');
            return redirect('/inventories')->with('error',  'Data tidak berhasil dihapus!');
        }
    }

    public function export() 
    {
        return Excel::download(new ExportInventory, 'inventory.xlsx');
    }

    public function pdf()
    {
        $data = Inventory::all();
        $pdf = PDF::loadView('inventory.laporan', compact('data'));

        return $pdf->download('inventory.pdf');
    }
}
