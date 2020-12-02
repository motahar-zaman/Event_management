<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

use App\Models\Projects;
use App\Models\Clients;
use App\Models\ClientsPayments;
use DB;
class ClientsPaymentsController extends Controller
{
    public function __construct(){

    }

    public function index()
    {
        $clients = Clients::where('status',1)->get();
        $projects = Projects::where('status',1)->get();
        $clientsPayment = ClientsPayments::orderBy('created_at','desc')->get();
        return view('clientsPayment',['projects' => $projects, 'clients' =>$clients, 'clientsPayments' => $clientsPayment]);
    }

    public function getProjects(Request $request)
    {
        $projects = Projects::where('status',1)->where('clients_name_id',$request->id)->get();
        $projects_view = '<option value="">Select</option>';
        foreach($projects as $pro){
            $projects_view .='<option value="'.$pro->id.'">'.$pro->name.'</option>';
        }
        return $projects_view;
    }

    public function addClientsPayments(Request $request){
        if($request->editId){
            $clientsPayments = ClientsPayments::find($request->editId);
            $clientsPayments->projects_name_id = $request->projects_name_id;
            $clientsPayments->clients_name_id = $request->clients_name_id;
            $clientsPayments->payment_usd = $request->payment_usd;
            $clientsPayments->payment_bdt = $request->payment_bdt;
            $clientsPayments->payment_jpy = $request->payment_jpy;
            $clientsPayments->note = $request->note;
            $clientsPayments->save();
            return redirect()->back()->with( 'success' , 'Successfully edited your Client Payment.');

        }else{
            $clientsPayments = new ClientsPayments;
            $clientsPayments->projects_name_id = $request->projects_name_id;
            $clientsPayments->clients_name_id = $request->clients_name_id;
            $clientsPayments->payment_usd = $request->payment_usd;
            $clientsPayments->payment_bdt = $request->payment_bdt;
            $clientsPayments->payment_jpy = $request->payment_jpy;
            $clientsPayments->note = $request->note;
            $clientsPayments->save();
            return redirect()->back()->with( 'success' , 'Successfully created new Client Payment.');
        }
    }

    public function editClientsPayments(Request $request){
        $clients = Clients::where('status',1)->get();
        $projects = Projects::where('status',1)->get();
        $clientsPayment = ClientsPayments::where('id',$request->id)->first();
        $clientsPayments = ClientsPayments::orderBy('created_at','desc')->get();
        return view('clientsPayment',['projects'=> $projects,'clients'=>$clients,'clientsPayments'=>$clientsPayments,'clientsPayment'=>$clientsPayment]);
    }

    public function deleteClientsPayments(Request $request){
        $clientsPayments = ClientsPayments::find($request->id)->delete();
        return redirect()->back()->with( 'success' , 'Successfully deleted your Client Payment.');
    }

}
