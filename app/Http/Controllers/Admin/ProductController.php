<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\GroupProduct;
use App\Models\Configuration;
use App\Models\Thumbnail;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();
        return view('admin.pages.product.display')->with(compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        $first_category = Category::first();
        $first_category_id = $first_category->id;
        $group_product = GroupProduct::where('category_id', $first_category_id)->get();
        //var_dump($group_product);
        return view('admin.pages.product.add')->with(compact('category', 'group_product'));
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
                'desc' => 'required',
                'price' => 'required',
                'import' => 'required',
                'qty' => 'required',
                'screen' => 'required',
                'ram' => 'required',
                'color' => 'required',
                'rear_camera' => 'required',
                'camera_selfie' => 'required',
                'os' => 'required',
                'memory' => 'required',
                'battery_capacity' => 'required',
                'origin' => 'required',
                'launch_time' => 'required',
                'cpu' => 'required',
                'gpu' => 'required',
                'sim' => 'required',

            ],
            [
                'image.required' => 'Bạn chưa chọn hình ảnh',
                'image.mimes' => 'Hình ảnh chỉ được phép có đuôi jpeg|jpg|png',
                'name.required' => 'Bạn chưa nhập tên sản phẩm',
                'name.unique' => 'Tên sản phẩm đã tồn tại',
                'desc.required' => 'Bạn chưa nhập mô tả sản phẩm',
                'price.required' => 'Bạn chưa nhập giá bán sản phẩm',
                'import.required' => 'Bạn chưa nhập giá nhập sản phẩm',
                'qty.required' => 'Bạn chưa nhập số lượng sản phẩm',
                'screen.required' => 'Bạn chưa nhập màn hình',
                'ram.required' => 'Bạn chưa nhập ram',
                'color.required' => 'Bạn chưa nhập màu sắc',
                'rear_camera.required' => 'Bạn chưa nhập camera sau',
                'camera_selfie.required' => 'Bạn chưa nhập camera selfie',
                'os.required' => 'Bạn chưa nhập hệ điều hành',
                'memory.required' => 'Bạn chưa nhập bộ nhớ trong',
                'battery_capacity.required' => 'Bạn chưa nhập dung lượng pin',
                'origin.required' => 'Bạn chưa nhập xuất xứ',
                'launch_time.required' => 'Bạn chưa nhập thời gian ra mắt',
                'cpu.required' => 'Bạn chưa nhập cpu',
                'gpu.required' => 'Bạn chưa nhập gpu',
                'sim.required' => 'Bạn chưa nhập sim',
            ]
        );

        $configuration = new Configuration;
        $configuration->screen = $request->screen;
        $configuration->ram = $request->ram;
        $configuration->color = $request->color;
        $configuration->rear_camera = $request->rear_camera;
        $configuration->camera_selfie = $request->camera_selfie;
        $configuration->os = $request->os;
        $configuration->memory = $request->memory;
        $configuration->battery_capacity = $request->battery_capacity;
        $configuration->origin = $request->origin;
        $configuration->launch_time = $request->launch_time;
        $configuration->cpu = $request->cpu;
        $configuration->gpu = $request->gpu;
        $configuration->sim = $request->sim;
        $configuration->save();

        $file = $request->file('image');
        //luu anh
        $name = $file->getClientOriginalName();
        do {
            $hinh = Str::random(3) . "_" . $name;
        } while (file_exists("img/product" . $hinh));
        $file->move("img/product", $hinh);
        $product = new Product;
        $product->product_name = $request->name;
        $product->configuration_id = $configuration->id;
        $product->slug_product = slug($request->name);
        $product->product_price = $request->price;
        $product->product_import = $request->import;
        $product->product_qty = $request->qty;
        $product->product_desc = $request->desc;
        $product->group_product_id = $request->group_product;
        $product->product_image = $hinh;
        $product->product_status = $request->status;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $product->created_at = now();
        $product->updated_at = now();
        $product->save();




        for ($i = 0; $i < 100; $i++) {
            $file = "file" . $i;
            if (isset($request->$file)) {
                $file = $request->file($file);
                $name = $file->getClientOriginalName();
                do {
                    $hinh = Str::random(3) . "_" . $name;
                } while (file_exists("img/thumbnail" . $hinh));
                $file->move("img/thumbnail", $hinh);
                $thumbnail = new Thumbnail();
                $thumbnail->link = $hinh;
                $thumbnail->product_id = $product->id;
                $thumbnail->status = 1;
                $thumbnail->save();
            }
        }
        return redirect('admin/san-pham/them')->with('thongbao', 'Thêm sản phẩm mới thành công');
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
        $product = Product::find($id);
        $category = Category::all();
        //$group_product=GroupProduct::where('category_id',$id)->get();
        return view('admin.pages.product.edit')->with(compact('product', 'category'));
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
            } while (file_exists("img/product" . $hinh));
            $file->move("img/product", $hinh);
        }
        $this->validate(
            $request,
            [
                'name' => 'required',
                'desc' => 'required',
                'price' => 'required',
                'import' => 'required',
                'qty' => 'required',

            ],
            [
                'name.required' => 'Bạn chưa nhập tên sản phẩm',
                'desc.required' => 'Bạn chưa nhập mô tả sản phẩm',
                'price.required' => 'Bạn chưa nhập giá bán sản phẩm',
                'import.required' => 'Bạn chưa nhập giá nhập sản phẩm',
                'qty.required' => 'Bạn chưa nhập số lượng sản phẩm',
            ]
        );

        $product = Product::find($id);
        if ($request->name != $product->product_name) {
            $this->validate(
                $request,
                ['name' => 'unique:product,product_name',],
                [
                    'name.unique' => 'Tên sản phẩm đã tồn tại',
                ]
            );
        }
        $product->product_name = $request->name;
        $product->slug_product = slug($request->name);
        $product->product_price = $request->price;
        $product->product_import = $request->import;
        $product->product_qty = $request->qty;
        $product->product_desc = $request->desc;
        $product->group_product_id = $request->group_product;
        if ($request->image) {
            $product->product_image = $hinh;
        }

        $product->product_status = $request->status;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $product->updated_at = now();
        $product->save();
        return redirect('admin/san-pham/sua/' . $id)->with('thongbao', 'Cập nhật sản phẩm mới thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->product_status = 0;
        $product->save();
        $thongbao = "Ẩn sản phẩm " . $product->product_name . " thành công";
        $product = Product::all();
        return view('admin.pages.product.display')->with(compact('product', 'thongbao'));
    }

    public function discount()
    {

        $product = Product::all();
        $group_product = GroupProduct::all();
        $category = Category::all();
        return view('admin.pages.product.discount')->with(compact('category', 'group_product', 'product'));
    }
    public function postDiscount(Request $request)
    {
        // $this->validate($request,[
        //     'money'=>'required|unique:product,product_name',
        //     'begin'=>'required',
        //     'end'=>'required',
        // ],
        // [
        //     'money.required'=>'Bạn chưa nhập số tiền|phần trăm giảm',

        //     'begin.required'=>'Bạn chưa chọn ngày bắt đầu khuyến mãi',

        //     'end.required'=>'Bạn chưa chọn ngày kết thúc khuyến mãi',

        // ]);
        //theo category
        if ($request->category != "") {
            $category = $request->category;
            $group_product = GroupProduct::where('category_id', $category)->get();
            foreach ($group_product as $gp) {
                $product = Product::where('group_product_id', $gp->id)->get();
                foreach ($product as $p) {
                    $product_price_km = 0;

                    //check kieu phan tram|tien
                    if ($request->type == 0) {
                        $product_price_km = $p->product_price - $request->money;
                    } else {
                        $product_price_km = $p->product_price - $request->money * $p->product_price / 100;
                    }
                    $p->bdkm = $request->begin;
                    $p->ktkm = $request->end;
                    $p->product_price_km = $product_price_km;
                    $p->save();
                }
            }
        }

        //theo brand
        else if ($request->group_product != "") {
            $group_product_id = $request->group_product;
            $product = Product::where('group_product_id', $group_product_id)->get();
            foreach ($product as $p) {
                $product_price_km = 0;

                //check kieu phan tram|tien
                if ($request->type == 0) {
                    $product_price_km = $p->product_price - $request->money;
                } else {
                    $product_price_km = $p->product_price - $request->money * $p->product_price / 100;
                }
                $p->bdkm = $request->begin;
                $p->ktkm = $request->end;
                $p->product_price_km = $product_price_km;
                $p->save();
            }
        }


        //theo product
        else if ($request->product != "") {
            $product = $request->product;
            $product = Product::where('id', $product)->get();
            foreach ($product as $p) {
                $product_price_km = 0;

                //check kieu phan tram|tien
                if ($request->type == 0) {
                    $product_price_km = $p->product_price - $request->money;
                } else {
                    $product_price_km = $p->product_price - $request->money * $p->product_price / 100;
                }
                $p->bdkm = $request->begin;
                $p->ktkm = $request->end;
                $p->product_price_km = $product_price_km;
                $p->save();
            }
        } else {
            $product = Product::all();
            foreach ($product as $p) {
                $product_price_km = 0;

                //check kieu phan tram|tien
                if ($request->type == 0) {
                    $product_price_km = $p->product_price - $request->money;
                } else {
                    $product_price_km = $p->product_price - $request->money * $p->product_price / 100;
                }
                $p->bdkm = $request->begin;
                $p->ktkm = $request->end;
                $p->product_price_km = $product_price_km;
                $p->save();
            }
        }
        $thongbao = "Áp dụng khuyến mãi thành công";
        return redirect('admin/san-pham/giam-gia')->with(compact('thongbao'));
    }
}
