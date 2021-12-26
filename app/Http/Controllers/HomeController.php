<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
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
    public function index()
    {
        $items = DB::table('items')->join('grouping', 'items.group', '=', 'grouping.id')->orderBy('ordering')->get();
        $groups = DB::table('grouping')->select('group_name')->get();
        return view('welcome', ['groups'=>$groups], ['items' =>$items]);
    }
}
