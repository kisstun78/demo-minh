<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data["products"] = Product::get();
        $data["cart"] = session()->get('cart', []);
        return view('home', $data);
    }

    public function order(StoreContactRequest $request)
    {
        $table = 'Đặt online';
        $cusName = $request->get('name');
        $phone = $request->get('phone');
        if ($request->get('table', '') !== ''){
            $table = $request->get('table');
        }

        $order = Order::create([
            'table' => $table,
            'customerName' => $cusName,
            'phone' => $phone,
            'total' => 0,
        ]);

        $products = session()->get('cart', []);

        $totalOrder = 0;

        foreach ($products as $productData) {
            $product = Product::find($productData['id']);
            $totalProduct = $product->price * $productData['qty'];

            $order->products()->attach($product->id, [
                'qty' => $productData['qty'],
                'total' => $totalProduct,
            ]);

            $totalOrder += $totalProduct;
        }

        $order->update(['total' => $totalOrder]);
        session()->forget('cart');
        return redirect(route('home.index'))->with('success','Bạn đã đặt hàng thành công');
    }
}
