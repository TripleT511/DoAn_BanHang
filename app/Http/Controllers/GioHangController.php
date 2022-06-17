<?php

namespace App\Http\Controllers;

use App\Models\GioHang;
use App\Http\Requests\StoreGioHangRequest;
use App\Http\Requests\UpdateGioHangRequest;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class GioHangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function renderCart()
    {
        $newCart = Session::get('Cart');
        $output = '';
        $total = 0;
        if ($newCart)
            foreach ($newCart as $item) {
                $total += (float)$item['gia'] * (int)$item['soluong'];
                $output .= '
                <li>
                    <a href="' . route('chitietsanpham', ['slug' => $item['slug']]) . '">
                        <figure>
                            <img src="' . asset('storage/' . $item['hinhAnh'])  . '" data-src="' . asset('storage/' . $item['hinhAnh'])  . 'g" alt="' . $item['tenSanPham'] . '" width="50" height="50" class="lazy">
                        </figure>
                        <strong>
                            <span>' . $item['soluong'] . 'x ' . $item['tenSanPham'] . '
                            </span>
                            ' . $item['gia'] . ' ₫
                        </strong>
                    </a>
                    <a href="#0" class="action"><i class="ti-trash"></i></a>
                </li>
            ';
            }
        return response()->json([
            'newCart' => $output,
            'numberCart' => $newCart ? count($newCart) : 0,
            'total' => $total
        ]);
    }
    public function themgiohang(Request $request)
    {
        $idSanPham = $request->sanphamId;
        $sanpham = SanPham::whereId($idSanPham)->first();
        $lstCart = Session::get('Cart');
        if ($lstCart) {
            if (isset($lstCart[$idSanPham])) {
                $lstCart[$idSanPham]['soluong'] = (int)$lstCart[$idSanPham]['soluong'] +  $request->soLuong;
                $lstCart[$idSanPham]['tongTien'] = (int)$lstCart[$idSanPham]['soluong'] *  (float)$lstCart[$idSanPham]['gia'];
            } else {
                $lstCart[$idSanPham] = array(
                    "id" => $idSanPham,
                    "tenSanPham" => $sanpham->tenSanPham,
                    'slug' => $sanpham->slug,
                    "hinhAnh" => $sanpham->hinhanhs->first()->hinhAnh,
                    "sku" => $sanpham->sku,
                    "soluong" => 1,
                    "gia" => $sanpham->gia,
                    "tongTien" => $sanpham->gia
                );
            }
            Session::put("Cart", $lstCart);
        } else {
            $lstCart[$idSanPham] = array(
                "id" => $idSanPham,
                "tenSanPham" => $sanpham->tenSanPham,
                'slug' => $sanpham->slug,
                "hinhAnh" => $sanpham->hinhanhs->first()->hinhAnh,
                "sku" => $sanpham->sku,
                "soluong" => 1,
                "gia" => $sanpham->gia,
                "tongTien" => $sanpham->gia
            );
            Session::put("Cart", $lstCart);
        }

        $newCart = Session::get('Cart');
        $output = '';
        $total = 0;
        if ($newCart)
            foreach ($newCart as $item) {
                $total += (float)$item['gia'] * (int)$item['soluong'];
                $output .= '
                <li>
                    <a href="' . route('chitietsanpham', ['slug' => $item['slug']]) . '">
                        <figure>
                            <img src="' . asset('storage/' . $item['hinhAnh'])  . '" data-src="' . asset('storage/' . $item['hinhAnh'])  . 'g" alt="' . $item['tenSanPham'] . '" width="50" height="50" class="lazy">
                        </figure>
                        <strong>
                            <span>' . $item['soluong'] . 'x ' . $item['tenSanPham'] . '
                            </span>
                            ' . $item['gia'] . ' ₫
                        </strong>
                    </a>
                    <a href="#0" class="action"><i class="ti-trash"></i></a>
                </li>
            ';
            }
        return response()->json([
            'message' => 'Sản phẩm ' . $sanpham->tenSanPham . ' đã được thêm vào giỏ hàng',
            'newCart' => $output,
            'numberCart' => $newCart ? count($newCart) : 0,
            'total' => $total,

        ]);
    }

    public function index()
    {
        $Cart = Session::get('Cart');
        $countCart = $Cart ? count($Cart) : 0;
        $total = 0;
        if ($Cart)
            foreach ($Cart as $item) {
                $total += (float)$item['gia'] * (int)$item['soluong'];
            }
        return view('cart', [
            'Cart' => $Cart ? $Cart : [],
            'countCart' => $countCart,
            'total' => $total
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGioHangRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGioHangRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GioHang  $gioHang
     * @return \Illuminate\Http\Response
     */
    public function show(GioHang $gioHang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GioHang  $gioHang
     * @return \Illuminate\Http\Response
     */
    public function edit(GioHang $gioHang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGioHangRequest  $request
     * @param  \App\Models\GioHang  $gioHang
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGioHangRequest $request, GioHang $gioHang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GioHang  $gioHang
     * @return \Illuminate\Http\Response
     */
    public function destroy(GioHang $gioHang)
    {
        //
    }
}
