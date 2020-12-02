<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

use App\Models\Projects;
use App\Models\Clients;
use DB;
class ProjectsController extends Controller
{
    public function __construct(){

    }

    public function index()
    {
        $clients = Clients::where('status',1)->get();
        $projects = Projects::orderBy('created_at','desc')->get();
        return view('projects',['projects'=> $projects,'clients'=>$clients]);
    }


    public function addProjects(Request $request){
        $projects = new Projects;

        $projects->name = $request->projectName;
        $projects->clients_name_id = $request->clientName;
        $projects->version_control = $request->versionControl;
        $projects->repository = $request->repository;
        $projects->note = $request->note;
        $projects->status = 1;
        $projects->save();
        return redirect()->back()->with( 'success' , 'Successfully created new projects.');
    }

    public function status(Request $request){
        $status = Projects::where('id',$request->statusId)->first();
        if($status->status == 1){
            $status = Projects::where('id',$request->statusId)->update(['status' => 0]);
        }
        else if($status->status == 0){
            $status = Projects::where('id',$request->statusId)->update(['status' => 1]);
        }
        return redirect()->back();
    }
}
