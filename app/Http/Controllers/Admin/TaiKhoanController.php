<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PhanQuyen;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreSanPhamRequest;
use App\Http\Requests\UpdateSanPhamRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;


class TaiKhoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function fixImage(User $user)
    {
        if (Storage::disk('public')->exists($user->anhDaiDien)) {
            $user->anhDaiDien = $user->anhDaiDien;
        } else {
            $user->anhDaiDien = 'images/no-image-available.jpg';
        }
    }
    public function index()
    {
        $lstTaiKhoan = User::with('phanquyen')->get();


        foreach ($lstTaiKhoan as $item) {
            $this->fixImage($item);
        }

        return View('admin.taikhoan.index-taikhoan', ['lstTaiKhoan' => $lstTaiKhoan]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lstPhanQuyen = PhanQuyen::all();
        return View('admin.taikhoan.create-taikhoan',['lstPhanQuyen'=> $lstPhanQuyen]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'hoTen' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'soDienThoai' => 'required|string',
            'anhDaiDien' => 'required',
            'phan_quyen_id' => 'required',
        ], [
            'hoTen.required' => 'Họ Tên không được bỏ trống',
            'email.required' => 'Email không được bỏ trống',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Mật khẩu không được bỏ trống',
            'soDienThoai.required' => 'Số điện thoại không được bỏ trống',
            'anhDaiDien.required' => 'Bắt buộc chọn Hình ảnh',
            'phan_quyen_id.required' => 'Bắt buộc chọn quyền',
        ]);
        $user= new User();
        $user-> fill([
            'hoTen' =>$request->input('hoTen'),
            'email' =>$request->input('email'),
            'password' =>Hash::make($request->password),
            'soDienThoai' =>$request->input('soDienThoai'),
            'phan_quyen_id'=>$request->input('phan_quyen_id'),
            'anhDaiDien' =>''
        ]);
        $user->save();
        
        if ($request->hasFile('anhDaiDien')) {        
            Storage::disk('public')->delete($user->anhDaiDien);
        $user->anhDaiDien = $request->file('anhDaiDien')->store('images/tai-khoan/', 'public'); 
    }
    $user->save();
    return Redirect::route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->fixImage($user);
        $lstPhanQuyen = PhanQuyen::all();
        return View('admin.taikhoan.edit-taikhoan',['user' => $user,'lstPhanQuyen'=> $lstPhanQuyen]);
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'hoTen' => 'required|string|max:255',
            'soDienThoai' => 'required|string',
            
        ], [
            'hoTen.required' => 'Họ Tên không được bỏ trống',
            'soDienThoai.required' => 'Số điện thoại không được bỏ trống',
        ]);
        $user-> fill([
            'hoTen' =>$user->hoTen,
            'email' =>$user->email,
            'password' =>$user->password,
            'soDienThoai' =>$user->soDienThoai,
            'phan_quyen_id'=>$user->phan_quyen_id,
            'anhDaiDien' =>$user->anhDaiDien
        ]);
        $user-> save();
        if ($request->hasFile('anhDaiDien')) {        
            Storage::disk('public')->delete($user->anhDaiDien);
             $user->anhDaiDien = $request->file('anhDaiDien')->store('images/tai-khoan', 'public'); 
        }
         $user->save();
         return Redirect::route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
       //
    }
}
