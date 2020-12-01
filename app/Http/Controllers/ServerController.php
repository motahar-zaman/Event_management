<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Email;
use App\Models\Projects;
use App\Models\Server;
use Illuminate\Http\Request;

class ServerController extends Controller{

    public function __construct(){

    }

    public function index(){
        $clients = Clients::where('status',1)->get();
        $projects = Projects::where('status',1)->get();
        $server = Server::all();
        return view('servers',['clients' => $clients, 'projects' => $projects, 'servers' => $server]);
    }

    public function addServer(Request $request){
        $server = new Server();
        $server->client_name = $request->clientName;
        $server->project_name = $request->projectName;
        $server->ip_address = $request->ip;
        $server->url = $request->url;
        $server->user_name = $request->user;
        $server->password = $request->password;
        $server->port = $request->port;
        $server->db_link = $request->dbLink;
        $server->db_user = $request->dbUser;
        $server->db_password = $request->dbPass;
        $server->note = $request->note;

        $server->save();
        return redirect()->route('client-server');
    }

    public function editServer(Request $request){
        var_dump("Hello editServer");
    }
}
