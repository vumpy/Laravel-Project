<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {


        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $group = $request->group;
        $order = $request->order;
        echo $order;

        if(isset($order)){
            $id = auth()->user()->id;
            $orders = DB::table('users')->select('order_quantity')->where('id', $id)->first();
            $new_order = $orders + 1;
            echo $new_order;
            $items = DB::table('users')->where('id', $id)->update(['order_quantity' => $new_order]);
        }

        
        $items = DB::table('items')->join('grouping', 'items.group', '=', 'grouping.id');

        if(isset($group)){
            $items = $items->where('grouping.id', '=', $group);
        }

        $items = $items->orderBy('ordering')->get();

        
        $groups = DB::table('grouping')->select('id','group_name')->get();
        return view('welcome', ['groups'=>$groups], ['items'=>$items]);

    }
}
