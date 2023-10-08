<?php

namespace App\Http\Controllers;

use App\Exports\ExportUser;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = User::all();
            return view('user.user', [
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Email or Password doesn`t match');
            return redirect('/dashboard')->with('toast_error',  'Halaman tidak dapat di akses! ');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            User::create([
                'role' => $request->role,
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'created_at' => now(),
            ]);
            //echo 'berhasil';
            Alert::success('Success!', 'Data insert successfully');
            return redirect('/users')->with('success', 'Data berhasil ditambah!');
        } catch (QueryException $e) {
            Alert::error('Error!', 'Data insert failed');
            return redirect('/users')->with('error',  'Halaman tidak dapat di akses! ');
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

            if ($request->passwordbaru!=null) {
                $pw = $request->passwordbaru;
            } else {
                $pw = $request->password;
            }

            User::where("id", $id)->update([
                'role' => $request->role,
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($pw),
                'updated_at' => now(),
            ]);
            Alert::success('Success!', 'Data update successfully');
            return redirect('/users')->with('success', 'Data berhasil diupdate!');
        } catch (QueryException $e) {
            echo $e->getMessage();
            //return redirect('/users')->with('error',  'Halaman tidak dapat di akses! ');
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
            $x = User::find($id);
            if ($x->id == auth()->user()->id) {
                return redirect('/users')->with('error',  'Tidak dapat menghapus akun sendiri!');
            } else {
                $x->delete();
            }
            Alert::success('Success!', 'Data deleted successfully');
            return redirect('/users')->with('success', 'Data berhasil dihapus!');
        } catch (QueryException $e) {
            return redirect('/users')->with('error',  'Data tidak berhasil dihapus!');
        }
    }

    public function export() 
    {
        return Excel::download(new ExportUser, 'user.xlsx');
    }

    public function pdf()
    {
        $data = User::all();
        $pdf = PDF::loadView('user.laporan', compact('data'));

        return $pdf->download('user.pdf');
    }
}
