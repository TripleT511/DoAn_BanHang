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
    public function index(Request $request)
    {
        $lstTaiKhoan = User::with('phanquyen')->paginate(3);
        if($request->block) {
            $lstTaiKhoan =  User::with('phanquyen')->onlyTrashed()->paginate(3);
        }elseif($request->phan_quyen_id){
            $lstTaiKhoan =  User::with('phanquyen')->where('phan_quyen_id', '=',$request->phan_quyen_id)->paginate(3);
        }


        foreach ($lstTaiKhoan as $item) {
            $this->fixImage($item);
        }

        return View('admin.taikhoan.index-taikhoan', ['lstTaiKhoan' => $lstTaiKhoan]);
    }

    public function searchTaiKhoan(Request $request)
    {
        $output = "";

        if ($request->input('txtSearch') != "") {
            
            $lstTaiKhoan = User::withCount('phanquyen')->where('hoTen', 'LIKE', '%' . $request->input('txtSearch') . '%')->orWhere('email', 'LIKE', '%' . $request->input('txtSearch') . '%')->orWhere('soDienThoai', '=',$request->input('txtSearch'))->withTrashed()->get();
            foreach ($lstTaiKhoan as $key => $item) {             
                $this->fixImage($item);                   
                $output2=''.($item->deleted_at == null) ? '<span class="badge bg-label-primary">Hoạt động</span>' : '<span class="badge bg-label-info">Bị khoá</span>'.'';
                $output3=''.($item->deleted_at == null) ? '
                <a class="btn btn-success" href="'. route('user.edit', ['user' => $item]) .'>
                 <i class="bx bx-edit-alt me-1"></i>Sửa
                </a>
                <form class="d-inline-block"  method="post" action="'. route('user.destroy',['user'=>$item]) .'">
                  <input type="hidden" name="_method" value="DELETE">
                  <input type="hidden" name="_token" value="'.csrf_token().'">
                     <button style="outline: none; border: none" class="btn btn-danger" type="submit"><i class="bx bx-trash me-1"></i> Khoá</button>
                </form>
                ' : '
                <a class="btn btn-success" href="'. route('mokhoa',['user'=>$item]) .'">
                <i class="bx bx-edit-alt me-1"></i>mở khoá
                </a>'
                .'';
                $output .= '
                <tr>
                <td>
                  <div class="img">
                      <img src="'.asset('storage/'.$item->anhDaiDien) .'" class="image-user " alt="'. $item->hoTen.'">
                  </div>
                </td>
                <td>'. $item->hoTen .'</td>
                <td>'. $item->email .' </td>
                <td>'. $item->soDienThoai .'</td>
                <td>'. $item->phanquyen->tenViTri.'</td>
                <td>'.$output2.'</td>
               <td>'.$output3.'</td>
              </tr>
                ';
            }
        }
        return response()->json($output);
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
            'email' => 'required|string|max:255',
            
        ], [
            'email.required' => 'Email không được bỏ trống',
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

    public function changepass(User $user)
    {
        return View('admin.taikhoan.change-password-taikhoan',['user' => $user]);
    } 

    public function doimatkhau(Request $request, User $user)
    {  
       
        $request->validate([
            'password' => 'required|string|min:6|max:16',
            'newpassword'=>'required',
        ], [
            'password.min'=>'Mật khẩu tối thiểu 6 ký tự',
            'password.max'=>'Mật khẩu tối đa 16 ký tự',
            'password.required' => 'Mật khẩu không được bỏ trống',
            'newpassword.required' => 'Xác nhận mật khẩu không được bỏ trống',
        ]);
        if(strcmp($request->password,$request->newpassword)==0){
        $user->fill([
            'password'=>Hash::make($request->password),
        ]);
        $user->save();
        return Redirect::route('user.index');
        }
        return View('admin.taikhoan.change-password-taikhoan',['user' => $user]);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->phan_quyen_id == 0) return redirect()->route('user.index')->withError('Bạn không thể xoá tài khoán này');
        elseif($user->phan_quyen_id != 0) $user->delete();
        return Redirect::route('user.index');
    }

    public function moKhoa($user)
    {
       $user = User::withTrashed()->find($user)->restore();
       return Redirect::route('user.index');
    }
}