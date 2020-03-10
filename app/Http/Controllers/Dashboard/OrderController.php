<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_products'])->only('index');
        $this->middleware(['permission:create_products'])->only('create');
        $this->middleware(['permission:update_products'])->only('edit');
        $this->middleware(['permission:delete_products'])->only('destroy');

    }// end of construct
    
    public function index(Request $request)
    {
        $orders = Order::whereHas('client', function($q) use ($request) {
            
            return $q->where('name', 'like', '%' . $request->search . '%');

        })->paginate(5);

        return view('dashboard.orders.index', compact('orders'));

    }// end of index

    public function products(Order $order)
    {
        $products = $order->products;

        return view('dashboard.orders._products', compact('order', 'products'));

    }// end of products  

    public function destroy(Order $order)
    {
        foreach ($order->products as $product) {

            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);

        }// end of foreach
        
        $order->delete();

        session()->flash('success', __('site.deleted_successfully'));        
        return redirect()->route('dashboard.orders.index');

    }// end of destroy

}// end of controller
