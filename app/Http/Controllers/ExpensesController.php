<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

use App\Models\Expenses;
use DB;
use Image;
class ExpensesController extends Controller
{
    public function __construct(){

    }

    //====Expenses List======//
    public function index()
    {    
        $expenses = Expenses::orderBy('created_at','desc')->get();
        return view('expenses',['expenses'=> $expenses]);
    }

    //====Add Expenses======//
    public function addExpenses(Request $request){


        if($request->editId){
            $expenses = Expenses::find($request->editId);
            $expenses->amount = $request->amount;
            $expenses->purpose = $request->purpose;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $name =time().'.'.$extension;
                $file->move(public_path().'/images/'.$name, 60);
                $expenses->receipt = $name;
            }
            else{
                $expenses->receipt = $expenses->receipt;
            }

            $expenses->save();
            return redirect()->back()->with( 'success' , 'Successfully edited expenses.');
        }else{
            $expenses = new Expenses;
            $expenses->amount = $request->amount;
            $expenses->purpose = $request->purpose;
            $name = '';
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $name =time().'.'.$extension;
                $file->move(public_path().'/images/'.$name, 60);
            }
            $expenses->receipt = $name;
            $expenses->save();
            return redirect()->back()->with( 'success' , 'Successfully entered new expenses.');
        }
    }

    //====Edit Expenses======//
    public function editExpenses(Request $request){
        $expenseses = Expenses::where('id',$request->id)->first();
        $expenses = Expenses::orderBy('created_at','desc')->get();
        return view('expenses',['expenseses'=>$expenseses,'expenses'=>$expenses]);
    }

    //====Delete Expenses======//
    public function deleteExpenses(Request $request){
        $expenses = Expenses::find($request->id)->delete();
        return redirect()->back()->with( 'success' , 'Successfully deleted your expenses.');
    }
}
