<?php
namespace App\Models;
use Codeigniter\Model;

class SupervisorModel extends Model{
    protected $table = "supervisors";
    protected $allowedFields = ['no_projects_supervised'];
}
