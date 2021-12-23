<?php

namespace App\Imports;

use App\Models\studentmarks;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentmarkImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
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
}
