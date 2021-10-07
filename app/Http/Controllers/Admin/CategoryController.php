<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::all();
        return view('admin.pages.category.display', ['category' => $category]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.category.add');
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
                'name' => 'required|unique:category,category_name',
                'desc' => 'required',
            ],
            [
                'name.unique' => 'Danh mục đã tồn tại',
                'name.required' => 'Tên danh mục không được để trống',
                'desc.required' => 'Mô tả danh mục không được để trống',
            ]
        );
        $category = new Category;
        $category->category_name = $request->name;
        $category->category_desc = $request->desc;
        $category->slug_category = slug($request->name);
        $category->category_status = $request->status;
        $category->save();
        return redirect('admin/danh-muc/them')->with('thongbao', 'Thêm danh mục thành công');
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
        $category = Category::find($id);
        return view('admin.pages.category.edit')->with(compact('category'));
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
        //unique:category,category_name
        //'name.unique'=>'Danh mục đã tồn tại',
        $this->validate(
            $request,
            [
                'name' => 'required',
                'desc' => 'required',
            ],
            [

                'name.required' => 'Tên danh mục không được để trống',
                'desc.required' => 'Mô tả danh mục không được để trống',
            ]
        );
        $category = Category::find($id);
        if ($request->name != $category->category_name) {
            $this->validate(
                $request,
                [
                    'name' => 'unique:category,category_name',
                ],
                [

                    'name.unique' => 'Danh mục đã tồn tại',
                ]
            );
        }
        $category->category_name = $request->name;
        $category->category_desc = $request->desc;
        $category->slug_category = slug($request->name);
        $category->category_status = $request->status;
        $category->save();
        return redirect('admin/danh-muc/sua/' . $id)->with('thongbao', 'Sửa danh mục thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // $id=$request->id;
        // $category=Category::find($id);
        // $category->category_status=0;
        // $category->save();
        // $thongbao="Ẩn danh muc ".$category->category_name." thành công";

        // $category=Category::all();
        // return view('admin.pages.category.display')->with(compact('category','thongbao'));
    }
    public function updateStatus(Request $request)
    {
        $id = $request->id;
        $category = Category::find($id);
        if ($category->category_status == 0) {
            $category->category_status = 1;
            $category->save();
        } else {
            $category->category_status = 0;
            $category->save();
        }
    }
}
