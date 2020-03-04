<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Client;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

}// end of controller
