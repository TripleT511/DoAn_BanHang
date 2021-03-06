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
            'hoTen.required' => 'H??? T??n kh??ng ???????c b??? tr???ng',
            'hoTen.max' => 'H??? T??n t???i ??a 255 k?? t???',
            'email.required' => 'Email kh??ng ???????c b??? tr???ng',
            'email.unique' => 'Email ???? t???n t???i',
            'email.email' => 'Email kh??ng h???p l???',
            'password.required' => 'M???t kh???u kh??ng ???????c b??? tr???ng',
            'soDienThoai.required' => 'S??? ??i???n tho???i kh??ng ???????c b??? tr???ng',
            'phan_quyen_id.required' => 'B???t bu???c ch???n quy???n',
        ]);

        if ($request->filled('soDienThoai')) {
            $request->validate([
                'soDienThoai' => 'regex:/((09|03|07|08|05)+([0-9]{8,9})\b)/'
            ], [
                'soDienThoai.regex' => 'S??? ??i???n tho???i kh??ng h???p l???'
            ]);
        }

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z0-9]).{6,}$/'
            ], [
                'password.regex' => 'M???t kh???u t???i thi???u 6 k?? t???, bao g???m s???, ch??? hoa v?? ch??? th?????ng'
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
            'diaChi' => 'required'

        ], [
            'email.required' => 'Email kh??ng ???????c b??? tr???ng',
            'hoTen.required' => 'H??? T??n kh??ng ???????c b??? tr???ng',
            'soDienThoai.required' => 'S??? ??i???n tho???i kh??ng ???????c b??? tr???ng',
            'diaChi.required' => '?????a ch??? kh??ng ???????c b??? tr???ng',
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
        ]);
        $user->save();
        if ($request->hasFile('anhDaiDien')) {
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
                'newpassword.required' => "M???t kh???u kh??ng ???????c b??? tr???ng",
                'newpassword.min' => "M???t kh???u ph???i c?? ??t nh???t 6 k?? t???",
                'confirm_password.required' => "X??c nh???n m???t kh???u kh??ng ???????c b??? tr???ng",
                'confirm_password.same' => "M???t kh???u nh???p l???i ch??a tr??ng kh???p",
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

        return response()->json(["success" => "?????i m???t kh???u th??nh c??ng"]);
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
            return back()->withError('B???n kh??ng quy???n s??? d???ng ch???c n??ng n??y');
        }

        $countAdmin = User::where('phan_quyen_id', 0)->count();
        if ($countAdmin == 1 && $user->phan_quyen_id == 0) {
            return redirect()->route('user.index')->withError('B???n kh??ng th??? kho?? t??i kho???n n??y');
        }

        if ($user->id == Auth()->user()->id) {
            return redirect()->route('user.index')->withError('B???n kh??ng th??? kho?? t??i kho???n n??y');
        }

        $user->delete();
        return Redirect::route('user.index');
    }

    public function moKhoa($user)
    {
        if (Auth()->user()->phan_quyen_id != 0) {
            return back()->withError('B???n kh??ng quy???n s??? d???ng ch???c n??ng n??y');
        }
        $user = User::withTrashed()->find($user)->restore();
        return Redirect::route('user.index');
    }
}
