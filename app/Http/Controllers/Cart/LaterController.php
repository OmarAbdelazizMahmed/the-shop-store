<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class LaterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        $item = Cart::instance('default')->get($id);
        Cart::instance('laterCart')->add($item->id, $item->name, $item->qty, $item->price, 0,
        [
            'totalQty' => $item->options->totalQty,'code' => $item->options->code,
            'main_image' => $item->options->main_image, 'slug' => $item->options->slug,
            'details' => $item->options->details,
        ])->associate('App\Models\Product');

        Cart::instance('default')->remove($id);

        return back();
    }


    public function moveToCart($id)
    {
        $item = Cart::instance('laterCart')->get($id);
        Cart::instance('default')->add($item->id, $item->name, $item->qty, $item->price, 0,
        [
            'totalQty' => $item->options->totalQty,'code' => $item->options->code,
            'main_image' => $item->options->main_image, 'slug' => $item->options->slug,
            'details' => $item->options->details,
        ])->associate('App\Models\Product');

        Cart::instance('laterCart')->remove($id);

        return back();
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
        //
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
        $request->validate([
            'quantity' => 'required|integer',
        ]);

        Cart::instance('laterCart')->update($id, $request->quantity);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function remove($id)
    {
        Cart::instance('laterCart')->remove($id);

        return back();
    }
}
