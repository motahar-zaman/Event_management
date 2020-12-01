<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

use App\Models\Clients;
use App\Models\Sales;
use DB;
class ClientsController extends Controller
{
    public function __construct(){

    }

    //====Clients List======//
    public function index()
    {    
        $clients = Clients::orderBy('created_at','desc')->get();
        return view('clients',['clients'=> $clients]);
    }

    //====Add Clients======//
    public function addClients(Request $request){
        $this->validate($request, array(
            'name' => 'required',
        ));
        $clients = Clients::orderBy('created_at','desc')->where('name',$request->name)->first();
        
        if($clients)
        {    
            return redirect()->back()->with( 'error' , 'Your clients name must be unique');
        }
        else{
            $clients = new Clients;
            $clients->name = $request->name;
            $clients->japanese_name = $request->japanese_name;
            $clients->status = 1;
            $clients->save();
            return redirect()->back()->with( 'success' , 'Successfully created new clients.');
        }
    }

    //====status Change======//
    public function status(Request $request){
        $status = Clients::where('id',$request->statusId)->first();
        if($status->status == 1){
            $status = Clients::where('id',$request->statusId)->update(['status' => 0]);
        }
        else if($status->status == 0){
            $status = Clients::where('id',$request->statusId)->update(['status' => 1]);
        }
        return redirect()->back();
    }

}
