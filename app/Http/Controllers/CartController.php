<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        // Lấy id và qty từ request
        $id = $request->input('pId');
        $qty = $request->input('qty', 1); // Mặc định số lượng là 1 nếu không có input qty
        $price = $request->input('pPrice', 1); // Mặc định số lượng là 1 nếu không có input qty
        $name = $request->input('pName', ''); // Mặc định số lượng là 1 nếu không có input qty

        // Lấy giỏ hàng từ session, nếu không có thì tạo một mảng rỗng
        $cart = session()->get('cart', []);

        // Kiểm tra nếu sản phẩm đã tồn tại trong giỏ hàng thì cập nhật số lượng
        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $qty;
        } else {
            // Nếu sản phẩm chưa có trong giỏ, thêm sản phẩm mới
            $cart[$id] = [
                "id" => $id,
                'name' => $name, // Đây chỉ là ví dụ
                'price' => $price, // Giá tạm thời
                "qty" => $qty
            ];
        }

        // Lưu lại giỏ hàng vào session
        session()->put('cart', $cart);

        return back()->with('success', 'Product added to cart successfully!');
    }

    public function viewCart()
    {
        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);

        // Trả về view hoặc JSON để hiển thị giỏ hàng
        return view('cart.view', compact('cart'));
    }

    public function removeFromCart($id)
    {
        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);

        // Xóa sản phẩm khỏi giỏ nếu tồn tại
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Xoá sản phẩm trong giỏ hàng thành công!');
    }

    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        $qty = $request->input('qty', 1);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] = $qty;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.view')->with('success', 'Giỏ hàng đã được cập nhật!');
    }

    public function clearCart()
    {
        // Xóa toàn bộ giỏ hàng khỏi session
        session()->forget('cart');

        return back()->with('success', 'All good!');
    }
}
