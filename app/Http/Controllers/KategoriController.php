<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\MyClass\Response;
use App\MyClass\Validations;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request){
        if ($request->ajax()) {
            return Kategori::DataTable($request);
        }

        return view('kategori.index',[
            'title' => 'Kategori',
            'description' => 'Ini adalah page untuk mengelola data kategori',
            'breadcrumbs' => [
                'title' => 'Data Kategori',
                'url' => route('kategori.index')
            ]
        ]);
    }

    public function store(Request $request){
        Validations::createKategori($request);
        DB::beginTransaction();
        try {
            Kategori::createKategori($request->all());
            DB::commit();

            return Response::success([
                'Data Kategori Berhasil Ditambahkan'
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return Response::error($e);
        }
    }

    public function get(Kategori $kategori){
        DB::beginTransaction();
        try {
            return Response::success([
                'kategori' => $kategori
            ]);
        } catch (Exception $e) {
            return Response::error($e);
        }
    }

    public function update(Request $request, Kategori $kategori){
        Validations::updateKategori($request, $kategori);
        DB::beginTransaction();
        try {
            $kategori->updateKategori($request->all());
            DB::commit();
            
            return Response::success([
                'message' => 'Data Kategori Berhasil Di Update'
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return Response::error($e);
        }
    }

    public function destroy(Kategori $kategori){
        DB::beginTransaction();
        try {
            $kategori->deleteKategori();
            DB::commit();

            return Response::success([
                'message' => 'Data Berhasil Di Hapus'
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return Response::error($e);
        }
    }


    public function getKategori(Request $request){
        try {
            $id = $request->id;
            $kategori = new Kategori();

            // $barang->where('id', $request->id)->first();
            $data = $kategori->where('id', $id)->get();

            return Response::success([
                'data' => $data
            ]);
        } catch (Exception $e) {
            return Response::error($e);
        }
    }
}
