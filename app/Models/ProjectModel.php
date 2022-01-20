<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{

   protected $table = 'projects';
   protected $allowedFields = ['title', 'created_by', 'abstract', 'supervisor_id', 'status','language'];


   // public function getAllProjectByUserID($userID) {
   //    $builder = $this->db->table('projects');
   //    // $builder->join('supervisors AS super', 'super.id = supervisor_id');
   //    $builder->join('users', 'user_id = supervisor_id');
   //    $builder = $this->where('created_by', $userID);
   //    return $builder->get();
   // }

   // public function FunctionName($projectData)
   // {
   //    // $this->db->table('projects');
   //    $this->db->insert('projects', $projectData);
   // }



}
