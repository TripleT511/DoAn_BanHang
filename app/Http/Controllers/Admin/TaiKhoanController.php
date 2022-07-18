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
use Illuminate\Support\Facades\Validator;
use Svg\Tag\Rect;

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
            $user->anhDaiDien = 'images/user-default.jpg';
        }
    }
    public function index(Request $request)
    {
        $lstTaiKhoan = User::with('phanquyen')->whereNot('id', 1)->paginate(5);

        if ($request->block) {
            $lstTaiKhoan =  User::with('phanquyen')->whereNot('id', 1)->onlyTrashed()->paginate(5);
        } elseif ($request->phan_quyen_id) {
            $lstTaiKhoan =  User::with('phanquyen')->whereNot('id', 1)->where('phan_quyen_id', '=', $request->phan_quyen_id)->paginate(5);
        }


        foreach ($lstTaiKhoan as $item) {
            $this->fixImage($item);
        }

        return View('admin.taikhoan.index-taikhoan', ['lstTaiKhoan' => $lstTaiKhoan]);
    }

    public function searchTaiKhoan(Request $request)
    {
        if (!empty($request->keyword)) {
            $lstTaiKhoan = User::with('phanquyen')->where([
                ['hoTen', 'LIKE', '%' . $request->input('keyword') . '%'],
                ['id', '<>', 1]
            ])
                ->orWhere([
                    ['email', 'LIKE', '%' . $request->input('keyword') . '%'],
                    ['id', '<>', 1]
                ])->orWhere([
                    ['soDienThoai', '=', $request->input('keyword')], ['id', '<>', 1]
                ])->withTrashed()->paginate(5);
            foreach ($lstTaiKhoan as $item) {
                $this->fixImage($item);
            }
        } else {
            return redirect()->back();
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
        return View('admin.taikhoan.create-taikhoan', ['lstPhanQuyen' => $lstPhanQuyen]);
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
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'soDienThoai' => 'required',
            'anhDaiDien' => 'required',
            'phan_quyen_id' => 'required',
        ], [
            'hoTen.required' => 'Họ Tên không được bỏ trống',
            'hoTen.max' => 'Họ Tên tối đa 255 kí tự',
            'email.required' => 'Email không được bỏ trống',
            'email.unique' => 'Email đã tồn tại',
            'email.email' => 'Email không hợp lệ',
            'password.required' => 'Mật khẩu không được bỏ trống',
            'soDienThoai.required' => 'Số điện thoại không được bỏ trống',
            'phan_quyen_id.required' => 'Bắt buộc chọn quyền',
        ]);

        if ($request->filled('soDienThoai')) {
            $request->validate([
                'soDienThoai' => 'regex:/((09|03|07|08|05)+([0-9]{8,9})\b)/'
            ], [
                'soDienThoai.regex' => 'Số điện thoại không hợp lệ'
            ]);
        }

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z0-9]).{6,}$/'
            ], [
                'password.regex' => 'Mật khẩu tối thiểu 6 kí tự, bao gồm số, chữ hoa và chữ thường'
            ]);
        }

        $user = new User();
        $user->fill([
            'hoTen' => $request->input('hoTen'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->password),
            'soDienThoai' => $request->input('soDienThoai'),
            'phan_quyen_id' => $request->input('phan_quyen_id'),
            'anhDaiDien' => '',
            'diaChi' => '',
        ]);
        $user->save();

        $user->email_verified_at = now();
        $user->save();

        if ($request->hasFile('anhDaiDien')) {
            if ($user->anhDaiDien != 'images/user-default.jpg') {
                Storage::disk('public')->delete($user->anhDaiDien);
            }
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
        return View('admin.taikhoan.edit-taikhoan', ['user' => $user, 'lstPhanQuyen' => $lstPhanQuyen]);
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

        $phanquyen = $request->phan_quyen_id;
        if (Auth()->user()->phan_quyen_id != 0) {
            $phanquyen = $user->phan_quuyen_id;
        }
        $user->fill([
            'hoTen' => $request->input('hoTen'),
            'email' => $request->input('email'),
            'password' => $user->password,
            'diaChi' => $request->input('diaChi'),
            'soDienThoai' => $request->input('soDienThoai'),
            'phan_quyen_id' => $phanquyen,
            'anhDaiDien' => $user->anhDaiDien
        ]);
        $user->save();
        if ($request->hasFile('anhDaiDien')) {
            if ($user->hinhAnh != 'images/user-default.jpg') {
                Storage::disk('public')->delete($user->hinhAnh);
            }
            $user->anhDaiDien = $request->file('anhDaiDien')->store('images/tai-khoan', 'public');
        }
        $user->save();
        return Redirect::route('user.index');
    }


    public function doimatkhau(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'newpassword' => 'required|min:6',
                'confirm_password' => 'required|same:newpassword',
            ],
            [
                'newpassword.required' => "Mật khẩu không được bỏ trống",
                'newpassword.min' => "Mật khẩu phải có ít nhất 6 ký tự",
                'confirm_password.required' => "Xác nhận mật khẩu không được bỏ trống",
                'confirm_password.same' => "Mật khẩu nhập lại chưa trùng khớp",
            ]
        );

        if ($validator->fails()) {
            $error = "";
            foreach ($validator->errors()->all() as $item) {
                $error .= '
                    <li class="card-description" style="color: #fff;">' . $item . '</li>
                ';
            }
            return response()->json(['error' => $error]);
        }

        $user = User::whereId($request->user_id)->first();

        $user->fill([
            'password' => Hash::make($request->newpassword),
        ]);
        $user->save();

        return response()->json(["success" => "Đổi mật khẩu thành công"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->id == 0) return back();
        if (Auth()->user()->phan_quyen_id != 0) {
            return back()->withError('Bạn không quyền sử dụng chức năng này');
        }

        $countAdmin = User::where('phan_quyen_id', 0)->count();
        if ($countAdmin == 1 && $user->phan_quyen_id == 0) {
            return redirect()->route('user.index')->withError('Bạn không thể khoá tài khoán này');
        }

        $user->delete();
        return Redirect::route('user.index');
    }

    public function moKhoa($user)
    {
        if (Auth()->user()->phan_quyen_id != 0) {
            return back()->withError('Bạn không quyền sử dụng chức năng này');
        }
        $user = User::withTrashed()->find($user)->restore();
        return Redirect::route('user.index');
    }
}
