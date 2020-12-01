<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Domain;
use App\Models\Projects;
use Illuminate\Http\Request;

class DomainController extends Controller{

    public function __construct(){

    }

    public function index(){
        $clients = Clients::where('status',1)->get();
        $projects = Projects::where('status',1)->get();
        $domain = Domain::all();
        return view('domains',['clients' => $clients, 'projects' => $projects, 'domains' => $domain]);
    }

    public function addDomain(Request $request){
        $domain = new Domain();
        $domain->client_name = $request->clientName;
        $domain->project_name = $request->projectName;
        $domain->url = $request->url;
        $domain->user_name = $request->user;
        $domain->password = $request->password;
        $domain->domain = $request->domain;
        $domain->registration_date = $request->reg;
        $domain->expiry_date = $request->expire;
        $domain->note = $request->note;

        $domain->save();
        return redirect()->route('client-domain');
    }

    public function editDomain(Request $request){
        var_dump("Hello editServer");
    }
}
