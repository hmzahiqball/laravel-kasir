<?php 

namespace App\MyClass;

use App\Rules\CheckPassword;

class Validations
{
    public static function createUser($request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['required'],
        ],[
            'name.required' => 'Nama Wajib Diisi',
            'email.required' => 'Email Wajib Diisi',
            'password.required' => 'Password Wajib Diisi',
            'phone.required' => 'No Hp Wajib Diisi',
        ]);
    }

    public static function updateUser($request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required'],
        ],[
            'name.required' => 'Nama Wajib Diisi',
            'email.required' => 'Email Wajib Diisi',
            'phone.required' => 'No Hp Wajib Diisi',
        ]);
    }

    public static function loginValidate($request){
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);
    }

    public static function setProfile($request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);
    }

    public static function setPassword($request, $userId){
        $request->validate([
			'old_password' => ['required', new CheckPassword($userId)],
			'password' => 'required',
			'confirm_password' => 'required|same:password',
		], [
			'old_password.required' => 'Password lama wajib diisi',
			'password.required' => 'Password baru wajib diisi',
			'confirm_password.required' => 'Wajib diisi',
			'confirm_password.same' => 'Password baru yang dimasukkan tidak sama',
		]);
    }

    public static function createKategori($request){
        $request->validate([
            'kode' => 'required|unique:kategoris,kode',
            'name' => 'required',
        ]);
    }

    public static function updateKategori($request, $kategori){
        $request->validate([
            'kode' => 'required|unique:kategoris,kode,'.$kategori->id,
            'name' => 'required',
        ]);
    }

    public static function createPromo($request){
        $request->validate([
            'name' => 'required',
            'kode' => 'required|unique:promos,kode',
            'tipe' => 'required|in:persen,nominal',
            'nilai' => 'required',
            'kuota' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date',
            'min_belanja' => 'required',
            'is_active' => 'required|in:aktif,nonaktif',
        ]);
    }

    public static function updatePromo($request, $promo){
        $request->validate([
            'name' => 'required',
            'kode' => 'required',
            'tipe' => 'required|in:persen,nominal',
            'nilai' => 'required',
            'kuota' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'min_belanja' => 'required',
            'is_active' => 'required|in:aktif,nonaktif',
        ]);
    }

    public static function createBarang($request){
        $request->validate([
            'kode' => 'required|unique:barangs,kode',
            'name' => 'required',
            'price' => 'required'
        ]);
    }

    public static function updateBarang($request, $barang){
        $request->validate([
            'kode' => 'required|unique:barangs,kode,'.$barang->id,
            'name' => 'required',
            'price' => 'required'
        ]);
    }

    public static function createCust($request){
        $request->validate([
            'code' => 'required|unique:customers,code',
            'name' => 'required',
            'telepon' => 'required'
        ]);
    }

    public static function updateCust($request, $cust){
        $request->validate([
            'code' => 'required|unique:customers,code,'.$cust->id,
            'name' => 'required',
            'telepon' => 'required'
        ]);
    }

    public static function createTransaksi($request){
        $request->validate([
            'kode' => 'required',
            'tanggal' => 'required',
            'cust_id' => 'required',
            'dataTable' => 'required'
        ]);
    }
}