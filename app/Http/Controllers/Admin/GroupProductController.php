<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\GroupProduct;
use Illuminate\Support\Str;

class GroupProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $group_product = GroupProduct::all();
        return view('admin.pages.groupProduct.display')->with(compact('group_product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        return view('admin.pages.groupProduct.add')->with(compact('category'));
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
                'image' => 'required|mimes:jpeg,jpg,png',
                'name' => 'required|unique:product,product_name',
                'review' => 'required',
            ],
            [
                'image.required' => 'Bạn chưa chọn hình ảnh',
                'image.mimes' => 'Hình ảnh chỉ được phép có đuôi jpeg|jpg|png',
                'name.required' => 'Bạn chưa nhập tên nhóm sản phẩm',
                'name.unique' => 'Tên nhóm sản phẩm đã tồn tại',
                'review.required' => 'Bạn chưa nhập review nhóm sản phẩm',
            ]
        );

        $file = $request->file('image');
        //luu anh
        $name = $file->getClientOriginalName();
        do {
            $hinh = Str::random(3) . "_" . $name;
        } while (file_exists("img/product" . $hinh));
        $file->move("img/product", $hinh);
        $group_product = new GroupProduct;
        $group_product->group_product_name = $request->name;
        $group_product->group_product_slug = slug($request->name);
        $group_product->group_product_review = $request->review;
        $group_product->group_product_desc = $request->desc;
        $group_product->category_id = $request->category;
        $group_product->group_product_image = $hinh;
        $group_product->status = $request->status;
        $group_product->save();
        return redirect('admin/nhom-san-pham/them')->with('thongbao', 'Thêm nhóm sản phẩm mới thành công');
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
        $group_product = GroupProduct::find($id);
        $category = Category::all();
        //$group_product=GroupProduct::where('category_id',$id)->get();
        return view('admin.pages.groupProduct.edit')->with(compact('group_product', 'category'));
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
        $hinh = "";
        if ($request->image) {
            $this->validate(
                $request,
                ['image' => 'required|mimes:jpeg,jpg,png',],
                [
                    'image.required' => 'Bạn chưa chọn hình ảnh',
                    'image.mimes' => 'Hình ảnh chỉ được phép có đuôi jpeg|jpg|png',
                ]
            );
            $file = $request->file('image');
            //luu anh
            $name = $file->getClientOriginalName();
            do {
                $hinh = Str::random(3) . "_" . $name;
            } while (file_exists("img/group" . $hinh));
            $file->move("img/product", $hinh);
        }
        $this->validate(
            $request,
            [
                'name' => 'required',
                'review' => 'required',
            ],
            [
                'name.required' => 'Bạn chưa nhập tên nhóm sản phẩm',
                'review.required' => 'Bạn chưa nhập review nhóm sản phẩm',
            ]
        );

        $group_product = GroupProduct::find($id);
        if ($request->name != $group_product->group_product_name) {
            $this->validate(
                $request,
                ['name' => 'unique:group_product,group_product_name',],
                [
                    'name.unique' => 'Tên sản phẩm đã tồn tại',
                ]
            );
        }
        $group_product->group_product_name = $request->name;
        $group_product->group_product_slug = slug($request->name);
        $group_product->group_product_review = $request->review;
        $group_product->group_product_desc = $request->desc;
        $group_product->category_id = $request->category;
        if ($request->image) {
            $group_product->group_product_image = $hinh;
        }

        $group_product->status = $request->status;
        $group_product->save();
        return redirect('admin/nhom-san-pham/sua/' . $id)->with('thongbao', 'Cập nhật sản phẩm mới thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group_product = GroupProduct::find($id);
        $group_product->status = 0;
        $group_product->save();
        $thongbao = "Ẩn sản phẩm " . $group_product->group_product_name . " thành công";
        $group_product = GroupProduct::all();
        return view('admin.pages.groupProduct.display')->with(compact('group_product', 'thongbao'));
    }
}
