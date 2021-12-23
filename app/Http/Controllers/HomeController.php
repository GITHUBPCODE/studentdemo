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

class HomeController extends Controller
{
    //


	public function upload() 
    {
        return view('upload');
    }	
	public function importstudent(Request $request) 
    {
        Excel::import(new StudentImport,request()->file('file'));
        return back()->with('msg','Student Details added !');
    }
	public function importmark(Request $request) 
    {
        Excel::import(new StudentmarkImport,request()->file('file'));
        return back()->with('msg','Student Mark Details added !');
    }	
	
	public function viewreport(Request $request) 
    {
        
		
		if ($request->ajax()) {
            $data = DB::select('	SELECT T1.id
											, T1.student_id
											, T1.name
											,T1.address
											,ifnull(T2.class,"NA")  as CLASS
											,IFNULL(SUM(T2.marks),0) AS TOTAL
											,CASE 	WHEN IFNULL(SUM(T2.marks),0) =0 THEN "ABSEND"
													WHEN IFNULL(SUM(T2.marks),0) <100 THEN  "FAIL"
													WHEN IFNULL(SUM(T2.marks),0) >=100 THEN "GOOD"
													ELSE "NA" END AS GRADE
									FROM studentdetails T1
									LEFT JOIN studentmarks T2 ON T2.studentid=T1.student_id
									GROUP BY T2.studentid, T2.class ');
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
		
		$ClassList = DB::select('SELECT ifnull(class,"NA") AS CLASS FROM studentmarks GROUP BY class ');
		return view('report',compact('ClassList'));
    }
	function showmark($studentid,$classname){
		$ID  = $studentid;
		$CLS = $classname;
		$table = studentmarks::where('studentid', $ID)->where('class', $CLS)->get();
		return $table;
	}
	
	
	function viewchart(){
		
				$data = DB::select(' SELECT class as store_name,
												subject as Time,
										   avg(marks) AS count
									FROM studentmarks
									GROUP BY class,subject DESC ');	
				//$data = json_encode($dataget , JSON_NUMERIC_CHECK);
				//return $data;
				return view('chart',compact('data'));
	}
	
}
