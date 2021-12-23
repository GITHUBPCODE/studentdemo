<?php

namespace App\Imports;

use App\Models\studentdetails;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class StudentImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
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
}