<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Client;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\CreateOrderRequest;
use App\Http\Requests\Orders\UpdateOrderRequest;
use App\Order;
use App\Product;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_orders'])->only('index');
        $this->middleware(['permission:create_orders'])->only('create');
        $this->middleware(['permission:update_orders'])->only('edit');
        $this->middleware(['permission:delete_orders'])->only('destroy');

    }// end of construct

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    }// end of index

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Client $client)
    {
        $categories = Category::with('products')->get();

        return view('dashboard.clients.orders.create', compact('client', 'categories'));

    }// end of create

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOrderRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrderRequest $request, Client $client)
    {
        $this->attach_order($request, $client);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.orders.index');

    }// end of store

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client, Order $order)
    {
        $categories = Category::with('products')->get();

        return view('dashboard.clients.orders.edit', compact('client', 'order', 'categories'));

    }// end of edit

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateOrderRequest $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Client $client, Order $order)
    {
        $this->detach_order($order);

        $this->attach_order($request, $client);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.orders.index');

    }// end of update

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client, Order $order)
    {
       
    }

    private function attach_order($request, $client)
    {
        $order = $client->orders()->create([]);

        $order->products()->attach($request->products);

        $total_price = 0;

        foreach ($request->products as $id=>$quantity) {
            
            $product = Product::FindOrFail($id);
            $total_price += $product->sale_price * $quantity['quantity'];

            $product->update([

                'stock' => $product->stock - $quantity['quantity']
            
            ]);

        }// end of foreach

        $order->update([
            
            'total_price' => $total_price
        
        ]);

    }// end of attach order

    private function detach_order($order)
    {
        foreach ($order->products as $product) {

            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);

        }// end of foreach
        
        $order->delete();

    }// end of detach order

}// end of controller
