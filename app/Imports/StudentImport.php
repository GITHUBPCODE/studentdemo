<?php

namespace App\Imports;

use App\Models\studentdetails;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\View\View;
class StudentImport implements  ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
	
    public function collection(Collection $rows)
    {
         Validator::make($rows->toArray(), [
             '*.student_id' => 'unique:App\Models\studentdetails,student_id|required',
             '*.name' => 'required',
             '*.class' => 'required',
             '*.address' => 'required',
             '*.dob' => 'required',
         ])->validate();
  
        foreach ($rows as $row) {
            studentdetails::create([
                'student_id' => $row['student_id'],
                'name' => $row['name'],
                'classname' => $row['class'],
                'address' => $row['address'],
                'dob' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['dob']),
            ]);
        }
    }	
	/*	
		public function model(array $row)
		{
			return new studentdetails([
				//
				'student_id'     => $row['student_id'],
				'name'    => $row['name'],
				'address'    => $row['address'],
				'dob'    => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['dob']),
			]);
		}
	*/	
}
