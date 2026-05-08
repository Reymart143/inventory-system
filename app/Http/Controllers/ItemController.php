<?php

namespace App\Http\Controllers;

use App\Models\item;
use Illuminate\Http\Request;
use DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = DB::table('items')->paginate(10);

        return view('item.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          return view('item.create');
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $items = DB::table('items')->insert([
            'item_name' => $request->item_name,
            'item_cost' => $request->item_cost,
            'safety_stock' => $request->safety_stock
        ]);
        return redirect()->route('items.index')->with('success', 'Item Added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(item $item)
    { 
        $item = DB::table('items')->where('id',$item->id)->first();
        return view('item.edit',compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, item $item)
    {
     $items = DB::table('items')
        ->where('id', $item->id)
        ->update([
            'item_name' => $request->item_name,
            'safety_stock' => $request->safety_stock,
            'item_cost' => $request->item_cost
        ]);
        return redirect()->route('items.index')->with('success', 'Item Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(item $item)
    {
        
        $item = DB::table('items')->where('id',$item->id)->delete();
        return redirect()->route('items.index')->with('success', 'Item Deleted successfully.');
    }
}
