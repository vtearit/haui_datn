<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slider = Slider::all();

        return view('admin.pages.slider.display')->with(compact('slider'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.slider.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'image' => 'required',
            ],
            [
                'image.required' => 'Bạn chưa chọn hình ảnh',
            ]
        );
        $slider = new Slider;
        $file = $request->file('image');

        //check file hop le
        $duoi = $file->getClientOriginalExtension();
        if ($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg') {
            return redirect('admin/tintuc/them')->with('errors', 'Bạn chỉ được chọn file có đuôi png,jpg,jpeg');
        }

        //luu anh
        $name = $file->getClientOriginalName();
        do {
            $hinh = Str::random(3) . "_" . $name;
        } while (file_exists("img/slider" . $hinh));
        $file->move("img/slider", $hinh);
        $slider->image = $hinh;
        $slider->status = $request->status;
        $slider->save();
        return redirect('admin/slider/them')->with('thongbao', 'Thêm slider thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slider = Slider::find($id);
        return view('admin.pages.slider.edit')->with(compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $slider = Slider::find($id);
        $image = $slider->image;
        if ($request->image) {
            $this->validate(
                $request,
                [
                    'image' => 'required',
                ],
                [
                    'image.required' => 'Bạn chưa chọn hình ảnh',
                ]
            );
            $file = $request->file('image');

            //check file hop le
            $duoi = $file->getClientOriginalExtension();
            if ($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg') {
                return redirect('admin/tintuc/them')->with('errors', 'Bạn chỉ được chọn file có đuôi png,jpg,jpeg');
            }

            //luu anh
            $name = $file->getClientOriginalName();
            do {
                $hinh = Str::random(3) . "_" . $name;
            } while (file_exists("img/slider" . $hinh));
            $file->move("img/slider", $hinh);
            $image = $hinh;
        }
        $slider->image = $image;

        $slider->status = $request->status;
        $slider->save();
        return redirect('admin/slider/sua/' . $id)->with('thongbao', 'Sửa slider thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::find($id);
        $thongbao = "Xóa slider " . $slider->id . " thành công";
        $slider->delete();
        $slider = Slider::all();
        return view('admin.pages.slider.display')->with(compact('slider', 'thongbao'));
    }
}
