<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Projects;
use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller{

    public function __construct(){

    }

    public function index(){
        $clients = Clients::where('status',1)->get();
        $projects = Projects::where('status',1)->get();
        $site = Site::all();
        return view('sites',['clients' => $clients, 'projects' => $projects, 'sites' => $site]);
    }

    public function addSite(Request $request){
        $server = new Site();
        $server->client_name = $request->clientName;
        $server->project_name = $request->projectName;
        $server->url = $request->url;
        $server->user_name = $request->user;
        $server->password = $request->password;
        $server->note = $request->note;

        $server->save();
        return redirect()->route('client-site');
    }

    public function editSite(Request $request){
        var_dump("Hello editServer");
    }
}
