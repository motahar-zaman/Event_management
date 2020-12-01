<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Email;
use App\Models\Projects;
use Illuminate\Http\Request;

class EmailController extends Controller{

    public function __construct(){

    }

    public function index(){
        $clients = Clients::where('status',1)->get();
        $projects = Projects::where('status',1)->get();
        $emails = Email::all();
        return view('emails',['clients' => $clients, 'projects' => $projects, 'emails' => $emails]);
    }

    public function addEmail(Request $request){
        $email = new Email();
        $email->client_name = $request->clientName;
        $email->project_name = $request->projectName;
        $email->email = $request->email;
        $email->password = $request->password;
        $email->note = $request->note;
        $email->created_at = date("Y-m-d H:i:s");

        $email->save();
        return redirect()->route('client-email');
    }

    public function editEmail(Request $request){
        var_dump("Hello editEmail");
    }
}
