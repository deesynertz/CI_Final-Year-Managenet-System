<?php

namespace App\Models;
use Codeigniter\Model;

class StudentModel extends Model{
    
    protected $table = 'students';
    protected $allowedFields = ['id','reg_number','academic_year','course_name','user_id'];
}