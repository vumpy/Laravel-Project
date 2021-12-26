<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'add_name' => ['required', 'string', 'max:255'],
            'add_price' => ['required', 'integer'],
            'add_ing' => ['required', 'string'],
            'add_group' => ['required', 'integer'],
        ]);
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
            $orders = DB::table('users')->select('order_quantity')->where('id', $id)->get();
            $new_order = $orders + 1;
            echo $new_order;
            $items = DB::table('users')->where('id', $id)->update(['order_quantity' => $new_order]);
        }

        
        $items = DB::table('items')->join('grouping', 'items.group', '=', 'grouping.id')->select('items.*', 'group_name');

        if(isset($group)){
            $items = $items->where('grouping.id', '=', $group);
        }

        $items = $items->orderBy('ordering')->get();

        
        $groups = DB::table('grouping')->select('id','group_name')->get();
        return view('admin', ['groups'=>$groups], ['items'=>$items]);

    }

    public function add()
    {
        return view('add');
    }

    public function save(Request $request)
    {
        $name = $request->add_name;
        $price = $request->add_price;
        $ings = $request->add_ing;
        $img = $request->add_img;
        $group = $request->add_group;
        $add_ordering = DB::table('items')->max('ordering');
        DB::table('items')->insert([
            ['name' => $name, 'price' => $price, 'img' => $img, 'ingredient' => $ings, 'ordering' => $add_ordering, 'group' => $group],
        ]);

        DB::table('items')->increment('ordering');
        header("Location: /admin");
        exit;
    }

    public function edit($id)
    {
        $post = DB::table('items')->join('grouping', 'items.group', '=', 'grouping.id')->where('items.id', $id)->get();
        return view('edit', ['post'=>$post], ['id'=>$id]);
    }

    public function save_edit(Request $request, $id)
    {
        $name = $request->add_name;
        $price = $request->add_price;
        $ings = $request->add_ing;
        $img = $request->add_img;
        $group = $request->add_group;
        $add_ordering = DB::table('items')->max('ordering');
        DB::table('items')->where('id', $id)->
            update(['name' => $name, 'price' => $price, 'img' => $img, 'ingredient' => $ings, 'ordering' => $add_ordering, 'group' => $group]);

        DB::table('items')->increment('ordering');
        header("Location: /admin");
        exit;
    }

    public function delete($id)
    {
        DB::table('items')->where('id', $id)->delete();
        header("Location: /admin");
        exit;
    }
}
