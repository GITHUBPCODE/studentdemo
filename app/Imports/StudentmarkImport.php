<?php

namespace App\Imports;

use App\Models\studentmarks;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\View\View;

class StudentmarkImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
         Validator::make($rows->toArray(), [
             '*.student_id' => 'required',
             '*.class' => 'required',
             '*.subject' => 'required',
             '*.marks' => 'required|numeric|min:1',
         ])->validate();
  
        foreach ($rows as $row) {
            studentmarks::create([
                'studentid' => $row['student_id'],
                'class' => $row['class'],
                'subject' => $row['subject'],
                'marks' => $row['marks'],
            ]);
        }
    }	
	
	/*
    public function model(array $row)
    {
        return new studentmarks([
            //
			'studentid'     => $row['student_id'],
            'class'    => $row['class'],
            'subject'    => $row['subject'],
            'marks'    => $row['marks'],
        ]);
    }
	*/
	
}
