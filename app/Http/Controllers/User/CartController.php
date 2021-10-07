<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use Cart;

class CartController extends Controller
{
    public function show_cart()
    {
        return view('frontend.pages.show_cart');
    }
    public function add_to_cart(Request $request)
    {
        Cart::add([
            'id' => $request->product_id,
            'name' => $request->product_name,
            'qty' => $request->product_qty,
            'price' => $request->product_price,
            'weight' => 0,
            'options' => [
                'image' => $request->product_image,
            ]
        ]);
    }
    public function update_quantity(Request $request)
    {
        $rowId = $request->rowId;
        $new_qty = $request->quantity;
        Cart::update($rowId, $new_qty);
        return redirect('/gio-hang');
    }
    public function delete(Request $request)
    {
        $rowId = $request->rowId_delete;
        Cart::remove($rowId);
        return redirect('/gio-hang');
    }
    public function qty_up($rowId, $id, $qty)
    {
        $new_qty = $qty + 1;
        Cart::update($rowId, $new_qty);
        echo $new_qty;
    }
    public function qty_down($rowId, $id, $qty)
    {
        $new_qty = $qty - 1;
        Cart::update($rowId, $new_qty);
        echo $new_qty;
    }
}
