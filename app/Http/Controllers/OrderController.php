<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Form;
use DB;
use App\Profile;
use App\Order;

class OrderController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index($id) {
        $perfil = Profile::find($id);
        return view('order.create', compact('perfil'));
    }

    public function store(Request $request) {
        
        $order = new Order();
        $order->profile_id = $request->profile_id;
        $order->items = $request->param1;
        $order->total = $request->param2;
        $order->save();

        return redirect()->route('order.add', $request->profile_id);    
    }

    public function get_all_by_idx($idx) {
        $perfil = Profile::find($idx);
        $orders = DB::table('orders')->where('profile_id', $idx)
        ->orderByRaw('created_at DESC')->get();
        return view('order.history', compact('orders', 'perfil'));
    }

    public function delete($id) {
        $profile = Order::find($id); 
        $profile->delete();
        return view('user');
    }

    public function delete_debit($id) {
        DB::table('historys')
        ->where('id',$id)
        ->delete();
        return view('user');
    }

    public function get_last_id() {
        $order = DB::table('orders')->select('id')->orderByRaw('id DESC')->get('id')->take(1);
        return $order[0]->id;
    }

    public function format_items($items) {
        $exp = explode("/", $items);
        foreach($exp as $i) {
            echo $i."</br>";
        }
    }

}
