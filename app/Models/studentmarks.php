<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class studentmarks extends Model
{
    use HasFactory;
	protected $table='studentmarks';
	protected $fillable =['studentid', 'class', 'subject', 'marks'];	
	
}
