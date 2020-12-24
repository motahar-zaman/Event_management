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

    public function index(Request $request)
    {
        $expenses = Expenses::orderBy('created_at','desc')->get();
        if(isset($request->success))
            return view('expenses',['expenses'=> $expenses, 'success' => $request->success]);
        else
            return view('expenses',['expenses'=> $expenses]);
    }

    public function addExpenses(Request $request){
        if($request->editId){
            $expenses = Expenses::find($request->editId);
            $expenses->amount = $request->amount;
            $expenses->purpose = $request->purpose;
            $expenses->transaction_date = $request->transaction_date;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $name =time().'.'.$extension;
                $file->move(public_path().'/images/',$name);
                $expenses->receipt = $name;
            }
            $expenses->save();
            $msg = "Successfully edited expenses";
        }
        else{
            $expenses = new Expenses;
            $expenses->amount = $request->amount;
            $expenses->purpose = $request->purpose;
            $expenses->transaction_date = $request->transaction_date;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $name =time().'.'.$extension;
                $file->move(public_path().'/images/',$name);
                $expenses->receipt = $name;
            }
            $expenses->save();
            $msg = "Successfully entered new expenses";
        }
        return redirect()->route('expenses-list', ['success' => $msg]);
    }

    public function editExpenses(Request $request){
        $expenseses = Expenses::where('id',$request->id)->first();
        $expenses = Expenses::orderBy('created_at','desc')->get();
        return view('expenses',['expenseses'=>$expenseses,'expenses'=>$expenses]);
    }

    public function deleteExpenses(Request $request){
        $expenses = Expenses::find($request->id)->delete();
        return redirect()->back()->with( 'success' , 'Successfully deleted your expenses.');
    }

    public function showImage(Request $request){
        $path = url('/images/'.$request->img);
        return view('showImage',['path'=>$path]);
    }
}
