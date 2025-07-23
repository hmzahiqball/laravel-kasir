<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model {
    use HasFactory;

    protected $guarded = ['id'];

    public static function createPromo($request){
    $data = self::create($request->only([
        'name',
        'kode',
        'tipe',
        'nilai',
        'kuota',
        'tanggal_mulai',
        'tanggal_akhir',
        'min_belanja',
        'is_active'
    ]));

    return $data;
}

    public function updatePromo($request){
        return $this->update($request);
    }
    
    public function deletePromo(){
        return $this->delete();
    }

    /**
     * For DataTables
     */
    public function getFormattedNilaiAttribute()
{
    if ($this->tipe === 'nominal') {
        return 'Rp. ' . number_format($this->nilai, 0, ',', '.');
    }

    return $this->nilai . '%';
}

public function getFormattedMinBelanjaAttribute()
{
    return 'Rp. ' . number_format($this->min_belanja, 0, ',', '.');
}

    public static function DataTable($request)
    {
        $data = self::select(['promos.*']);

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
                    <a class="dropdown-item edit" data-get-href="' . route('promo.get', $data->id) . '" data-update-href="' . route('promo.update', $data->id) . '"><i class="bi bi-pencil-square me-50"></i> Edit</a>
                    <a class="dropdown-item delete" data-delete-message="Yakin Ingin Menghapus Data ' . $data->kode . '" data-delete-href="' . route('promo.destroy', $data->id) . '"><i class="bi bi-trash3 me-50"></i> Delete</a>
                    </div>
                </div>

                ';
                return $action;
            })
            ->editColumn('nilai', function($data){
    return $data->formatted_nilai;
})
->editColumn('min_belanja', function($data){
    return $data->formatted_min_belanja;
})
            ->rawColumns(['action', 'nilai'])
            ->make(true);
    }
}