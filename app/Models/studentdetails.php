<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class studentdetails extends Model
{
    use HasFactory;
	
	protected $table='studentdetails';
	protected $fillable =['student_id', 'name', 'classname','address', 'dob'];
	
	
	
}
