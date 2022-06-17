<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


use App\Models\Slider;
use App\Http\Requests\StoreSliderRequest;
use App\Http\Requests\UpdateSliderRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function fixImage(Slider $slider)
    {
        if (Storage::disk('public')->exists($slider->hinhAnh)) {
            $slider->hinhAnh = $slider->hinhAnh;
        } else {
            $slider->hinhAnh = 'images/no-image-available.jpg';
        }
    }
    public function index()
    {
        $lstSlider = Slider::all();
        foreach ($lstSlider as $item) {
            $this->fixImage($item);
        }
        return View('admin.slideshow.index-slideshow', ['lstSlider' => $lstSlider]);
    }

    public function searchSlider(Request $request)
    {
        $output = "";

        if ($request->input('txtSearch') != "") {
            $lstSlider = Slider::where('tieuDe', 'LIKE', '%' . $request->input('txtSearch') . '%')->get();
            foreach ($lstSlider as $key => $item) {
                $this->fixImage($item);

                $output .= '
                    <tr> 
                    <td>
                    <div class="img">
                        <img src="' . asset('storage/' . $item->hinhAnh) . '" class="image-product" alt="' . $item->tieuDe . '">
                    </div>
                    </td>
                    <td>
                    ' . $item->tieuDe  . '
                    </td>
                    <td>
                    ' . $item->slug . '
                    </td>
                    <td>
                    ' . $item->noiDung . '
                    </td>
                    <td>
                    <a class="btn btn-success" href="' . route('slider.edit', ['slider' => $item]) . '">
                        <i class="bx bx-edit-alt me-1"></i>Sửa
                    </a>
                    <form class="d-inline-block" method="post" action="' . route('slider.destroy', ['slider' => $item]) . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <button style="outline: none; border: none" class="btn btn-danger" type="submit"><i class="bx bx-trash me-1"></i> Xoá</button>
                    </form>
                    </td>
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
        return View('admin.slideshow.create-slideshow');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSliderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSliderRequest $request)
    {
        $request->validate([
            'tieuDe' => 'required|unique:sliders',
            'hinhAnh' => 'required',
            'noiDung' => 'required',
        ], [
            'tieuDe.required' => "Tiêu đề không được bỏ trống",
            'hinhAnh.required' => "Hình ảnh không được bỏ trống",
            'noiDung.required' => "Nội dung không được bỏ trống",
            'tieuDe.unique' => "Tiêu đề bị trùng",
        ]);

        $slug = '';
        if ($request->filled('slug')) {
            $slug = $request->input('slug');
        } else {
            $slug = Str::of($request->input('tieuDe'))->slug('-');
        }



        $slider = new Slider();
        $slider->fill([
            'hinhAnh' => '',
            'tieuDe' => $request->input('tieuDe'),
            'noiDung' => $request->input('noiDung'),
            'slug' => $slug,
        ]);
        $slider->save();

        if ($request->hasFile('hinhAnh')) {
            $slider->hinhAnh = $request->file('hinhAnh')->store('images/slideshow', 'public');
        }
        $slider->save();

        return Redirect::route('slider.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        $lstSlider = Slider::all();
        foreach ($lstSlider as $item) {
            $this->fixImage($item);
        }
        return View('admin.slideshow.edit-slideshow', ['slider' => $slider]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSliderRequest  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSliderRequest $request, Slider $slider)
    {
        $request->validate([
            'tieuDe' => 'required',
            'noiDung' => 'required',
        ], [
            'tieuDe.required' => "Tiêu đề không được bỏ trống",
            'noiDung.required' => "Nội dung không được bỏ trống",
        ]);

        $slug = '';
        if ($request->filled('slug')) {
            $slug = $request->input('slug');
        } else {
            $slug = Str::of($request->input('tieuDe'))->slug('-');
        }

        $slider->fill([
            'hinhAnh' => $slider->hinhAnh,
            'tieuDe' => $request->input('tieuDe'),
            'noiDung' => $request->input('noiDung'),
            'slug' => $slug,
        ]);
        $slider->save();

        if ($request->hasFile('hinhAnh')) {
            Storage::disk('public')->delete($slider->hinhAnh);
            $slider->hinhAnh = $request->file('hinhAnh')->store('images/slideshow', 'public');
        }
        $slider->save();
        return Redirect::route('slider.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {

        Storage::disk('public')->delete($slider->hinhAnh);
        $slider->delete();

        $slider->delete();
        return Redirect::route('slider.index');
    }
}
