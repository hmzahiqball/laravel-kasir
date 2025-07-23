<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\Setting;
use App\MyClass\Response;
use App\MyClass\Validations;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromoPajakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Promo::DataTable($request);
        }

        return view('promo.index',[
            'title' => 'Promo dan Pajak',
            'description' => 'Ini adalah page untuk mengelola data promo',
            'breadcrumbs' => [
                'title' => 'Data Promo',
                'url' => route('promo.index')
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Validations::createPromo($request);
        DB::beginTransaction();
        try {
            Promo::createPromo($request);
            DB::commit();

            return Response::success([
                'Data Promo Berhasil Ditambahkan'
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return Response::error($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function get(Promo $promo)
    {
        DB::beginTransaction();
        try {
            return Response::success([
                'promo' => $promo
            ]);
        } catch (Exception $e) {
            return Response::error($e);
        }
    }

    public function getTax()
    {
        try {
            $tax = Setting::getValue('tax', 12); // default 12 kalau belum di-set
        
            return response()->json([
                'success' => true,
                'tax' => $tax
            ]);
        } catch (Exception $e) {
            return Response::error($e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promo $promo)
    {
        Validations::updatePromo($request, $promo);
        DB::beginTransaction();
        try {
            $promo->updatePromo($request->all());
            DB::commit();
            
            return Response::success([
                'message' => 'Data Promo Berhasil Di Update'
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return Response::error($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promo $promo)
    {
        DB::beginTransaction();
        try {
            $promo->deletePromo();
            DB::commit();

            return Response::success([
                'message' => 'Data Berhasil Di Hapus'
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return Response::error($e);
        }
    }
}
