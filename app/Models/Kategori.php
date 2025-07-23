<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * For Crud
     */
    public static function createKategori($request){
        $data = self::create($request);

        return $data;
    }

    public function updateKategori($request){
        return $this->update($request);
    }
    
    public function deleteKategori(){
        return $this->delete();
    }

    /**
     * For DataTables
     */
    public function setPrice(){
        return '<span> Rp. '.number_format($this->price).'</span>';
    }

    public static function DataTable($request)
    {
        $data = self::select(['Kategoris.*']);

        return \DataTables::eloquent($data)
            ->addColumn('action', function ($data) {
                $action = '
                <div class="dropdown">
                    <button
                    class="btn btn-primary dropdown-toggle me-1"
                    type="button"
                    id="dropdownMenuButtonIcon"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                    >
                    <i class="bi bi-error-circle me-50"></i> Pilih Aksi
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon">
                    <a class="dropdown-item edit" data-get-href="' . route('kategori.get', $data->id) . '" data-update-href="' . route('kategori.update', $data->id) . '"><i class="bi bi-pencil-square me-50"></i> Edit</a>
                    <a class="dropdown-item delete" data-delete-message="Yakin Ingin Menghapus Data ' . $data->kode . '" data-delete-href="' . route('kategori.destroy', $data->id) . '"><i class="bi bi-trash3 me-50"></i> Delete</a>
                    </div>
                </div>

                ';
                return $action;
            })
            ->editColumn('price', function($data){
                return $data->setPrice();
            })
            ->rawColumns(['action', 'price'])
            ->make(true);
    }
}
