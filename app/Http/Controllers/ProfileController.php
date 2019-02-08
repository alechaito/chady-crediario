<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Form;
use DB;
use Carbon\Carbon;
use App\Profile;

class ProfileController extends Controller
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
    public function index() {
        return view('user');
    }

    public function index_add_user() {
        return view('adduser');
    }

    public function delete($id) {
        $profile = Profile::find($id); 
        $profile->delete();
        return view('user');
    }

    public function store(Request $request) {   
        $profile = new Profile();
        $profile->name = $request->name;
        $profile->cpf = $request->cpf;
        $profile->save();

        return redirect()->route('profile.index');    
    }

    public function debit_post(Request $request) {   
        $id = $request->prof_id;
        $perfil = Profile::find($id);
        DB::table('historys')->insert(
            [
                'profile_id' => $request->prof_id,
                'value' => number_format($request->value, 2, '.', '.'),
                'type' => $request->type,
                'created_at' => new \DateTime(),
            ]
        );

        return view('debit.index', compact('id', 'perfil'));;    
    }

    public function get_all() {
        return Profile::All();  
    }


    // History Page
    // Default history
    public function history($id) {
        $perfil = Profile::find($id);
        //QUERY TO GET HISTORY BY DESC
        $history = DB::table('historys')
        ->where('profile_id', $id)
        ->orderByRaw('created_at DESC')->get();
        return view('debit.history', compact('history', 'perfil'));
    }

    // Return a index to debit
    public function debit($id) {
        $perfil = Profile::find($id);
        return view('debit.index', compact('id', 'perfil'));
    }

    public function get_total_paid($id) {
        $history = DB::table('historys')->where('profile_id', $id)->get();
        $total = 0;
        foreach($history as $hist) {
            $total = $total + $hist->value;
        }
        return $total;
    }

    public function get_total_unpaid($id) {
        $unpaid = DB::table('orders')->where('profile_id', $id)->get();
        $total = 0;
        foreach($unpaid as $hist) {
            $total = $total + $hist->total;
        }
        $paid = ProfileController::get_total_paid($id);
        $total = $total-$paid;
        return $total;
    }

    public function get_total($id) {
        $unpaid = DB::table('orders')->where('profile_id', $id)->get();
        $total = 0;
        foreach($unpaid as $hist) {
            $total = $total + $hist->total;
        }
        return $total;
    }

    // GET TOTAL PAID WITH CARD OR MONEY OF PROFILE
    public function get_total_info($id) {
        $history = DB::table('historys')->where('profile_id', $id)->get();
        $total_card = 0;
        $total_money = 0;
        foreach($history as $hist) {
            if($hist->type == 0) {
                $total_money += $hist->value;
            }
            else {
                $total_card += $hist->value;
            }
        }
        $res = array($total_money, $total_card);
        return $res;
    }

    // GET TOTAL DEBIT PAID WITH CARD OR MONEY FROM ALL PROFILES
    public function get_all_total_info() {
        $users = DB::table('profiles')->select('id')->get();
        $total_card = 0;
        $total_money = 0;
        //var_dump($users);
        foreach($users as $user) {
            $total_money += ProfileController::get_total_info($user->id)[0];
            $total_card +=  ProfileController::get_total_info($user->id)[1];
        }
        $res = array($total_money, $total_card);
        return $res;
    }

    // GET TOTAL ORDERS PAID WITH CARD OR MONEY FROM ALL PROFILES
    public function total_orders() {
        $users = DB::table('profiles')->select('id')->get();
        $total = 0;
        //var_dump($users);
        foreach($users as $user) {
            $total += ProfileController::get_total($user->id);
        }
        return $total;
    }



    public function search(Request $req){
        $result = explode("/", $req->name);
        $profile = Profile::find($result[0]);
        return view('profile', compact('profile'));
    }

    public function search_date($idx, $string, $iduser) {
        $start = Carbon::now();
        $end = Carbon::now()->subMonth($idx);
        $query = DB::table($string)->where('profile_id', $iduser)
        ->whereBetween('created_at', [$end, $start])
        ->orderByRaw('created_at DESC')->get();
        return $query;
    }


    // FILTER ORDER BY MOUNT IDX: qnt mount, ID_USER: profile
    public function order_filter($idx, $iduser) {
        $orders = ProfileController::search_date($idx, 'orders', $iduser);
        $perfil = Profile::find($iduser);
        return view('order.history', compact('orders', 'perfil'));

    }

     // FILTER DEBITS BY MOUNT IDX: qnt mount, ID_USER: profile
    public function debit_filter($idx, $iduser) {
        $history = ProfileController::search_date($idx, 'historys', $iduser);
        $perfil = Profile::find($iduser);
        return view('debit.history', compact('history', 'perfil'));

    }

    public function get_user() {
        return Auth::User()->id;
    }

}
