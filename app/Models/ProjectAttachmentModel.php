<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectAttachmentModel extends Model
{
   protected $table = 'projects_attachments';
   protected $allowedFields = ['id', 'name', 'project_id', 'phase','created_at','updated_at'];

   public function projects_attachments_count()
   {


      $sql="Select COUNT(*) as progress from projects_attachments JOIN  projects AS p ON  project_id = p.id where created_by = '".$_SESSION['user_id']."'";    
      // $query = $this->db->query($sql);
      // return $query->result();

      // return $this->db->query($sql)->getResultArray();
      return $this->db->query($sql)->getRow();


      // $builder = $this->db->table('projects_attachments');
      // $builder->join('projects AS p', '');
      // $builder = $this->where('created_by', $_SESSION['user_id']);
      // return $builder->get();
   }



}
