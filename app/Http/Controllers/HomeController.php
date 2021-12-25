<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\studentdetails;
use App\Models\studentmarks;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentImport;
use App\Imports\StudentmarkImport;
use DataTables;
use DB;
use Illuminate\Support\Facades\Validator;
class HomeController extends Controller
{
    //


	public function upload() 
    {
        return view('upload');
    }	
	public function importstudent(Request $request) 
    {
        $getdatta = Excel::import(new StudentImport,request()->file('file'));
		return back()->with('msg','Student Details added !');
    }
	public function importmark(Request $request) 
    {
        $getdatta = Excel::import(new StudentmarkImport,request()->file('file'));
		
        return back()->with('msg','Student Mark Details added !');
    }	
	
	public function viewreport(Request $request) 
    {
        
		
		if ($request->ajax()) {
            $data = DB::select('	SELECT X.*
									,CASE 	WHEN X.TOTAL THEN "ABSEND"
											WHEN X.TOTAL <100 THEN  "FAIL"
											WHEN X.TOTAL >=100 THEN "GOOD"
											ELSE "NA" END AS GRADE
									FROM
									(SELECT T1.id
											, T1.student_id
											, T1.name
											,T1.address
											,ifnull(T1.classname,"NA")  as CLASS
											,ifnull((SELECT SUM(T2.marks) FROM studentmarks T2 WHERE T2.studentid=T1.student_id),0) AS TOTAL
											
									FROM studentdetails T1
                                    )X ') ;
            //$data = studentdetails::select('*')->get();
			//return $data;
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"  >View</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
		
		$ClassList = DB::select('SELECT ifnull(classname,"NA") AS CLASS FROM studentdetails GROUP BY class ');
		return view('report',compact('ClassList'));
    }
	function showmark($studentid,$classname){
		$ID  = $studentid;
		$CLS = $classname;
		$table = studentmarks::where('studentid', $ID)->where('class', $CLS)->get();
		return $table;
	}
	
	
	function viewchart(){
		
				$data = DB::select(' SELECT class as Time,
												subject as store_name,
										   avg(marks) AS count
									FROM studentmarks
									GROUP BY class,subject DESC ');	
				//$data = json_encode($dataget , JSON_NUMERIC_CHECK);
				//return $data;
				return view('chart',compact('data'));
	}
	function ajaxsubmit(Request $request){
		//return $request;
		
		 foreach($request->student_id as $key =>$student_id){
            $data = array(
                            'student_id'=>$request->student_id[$key],
                            'name'=>$request->name[$key],
                            'classname'=>$request->classname[$key],
                            'address'=>$request->address[$key],
                            'dob'=>$request->dob[$key],
                );
				
         Validator::make($data, [
             'student_id' => 'unique:App\Models\studentdetails,student_id|required',
             'name' => 'required',
             'classname' => 'required',
             'address' => 'required',
		 'dob' => 'required|date',
         ])->validate();
		 studentdetails::insert($data);
		 return 1;

			/*
			$chk = DB::select('select count(0) as SCOUNT from studentdetails where student_id='.$request->student_id[$key].'');
			if(($request->student_id[$key]=='' || $request->student_id[$key]==null || $request->student_id[$key]=='null')){
				return 'Check Excel Data !  Student id empty';
			}else if(($chk[0]->SCOUNT==0)){
				studentdetails::insert($data);
				return 'Student Details added !';
			}else if(($chk[0]->SCOUNT>0)){
				return 'Check Excel Data ! student id dublicate';
			} else if(($request->name[$key]=='' || $request->name[$key]==null || $request->name[$key]=='null')){
				return 'Check Excel Data ! name empty';
			} else if(($request->classname[$key]=='' || $request->classname[$key]==null || $request->classname[$key]=='null')){
				return 'Check Excel Data ! classname empty';
			}else{
				return 'Check Excel Data ! ';
			}
			*/
			
        }
		
	}
	
}
