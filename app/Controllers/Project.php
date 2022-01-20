<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\SupervisorModel;
use App\Models\ProjectAttachmentModel;
use App\Models\StudentModel;

use function PHPUnit\Framework\fileExists;

class Project extends BaseController
{
    public function index()
    {
        $userID = $_SESSION['user_id'];
        $project = new ProjectModel();

        $data['projects'] = $project->join('supervisors AS super', 'super.id = supervisor_id')
        ->join('users AS user', 'user.user_id = super.user_id')
        ->where('created_by', $userID)->get()->getResult();

        if (!empty($data['projects'])){
            $projectAtt = new ProjectAttachmentModel();
            foreach ($data['projects'] as $project){
                $data['projectAtts'] = $projectAtt->where('project_id', $project->id)
                ->get()->getResult();
            }
        }

        return view('/Project/index', $data);
    }

    public function register()
    {
        $userID = $_SESSION['user_id'];

        $db = \Config\Database::connect();
        $data = [];
        $response = [];
        $project = new ProjectModel();

        $supervisor = new SupervisorModel();
        $data = $this->request->getRawInput();
        $projectData = [
            'title' => $data['title'],
            'created_by' => $userID,
            'abstract' => $data['abstract'],
            'language' => $data['language']
        ];

        // ALGO
        // get existing projects' abstracts array
        $projects = $project->get()->getResult();

        // loop existing projects' abstracts array
        foreach ($projects as $project) {
            // explode single abstract words by space into array
            $words = explode(' ', $project->abstract);
            // count single abstract words
            $words_count = count($words);
            // set counter to 0
            $counter = 0;
            // explode by space request body abstract into words array
            $req_words = explode(' ', $data['abstract']);
            // compare request body abstract words array with existing abstract words array by looping
            for ($x = 0; $x < $words_count; $x++) {
                // increase counter when the words match exactly
                if ($req_words[$x] === $words[$x]) {
                    $counter++;
                }
            }
            // divide counter final value to single abstract words count
            $result = $counter / $words_count;
            // if result is atleast 0.5 value
            if ($result > 0.5) {
                // dont create project - (duplicate / plagerism)
                // return response error message to a user
                $response['status'] = "danger";
                $response['message'] = $data['title'] . " project is a duplicate!, please register new one";
                echo json_encode($response);
                die;

                $this->index();
            }
        }
        //if not result is less 0.5
        // get supervisors projects count(s)
        $supervisors = $supervisor->get()->getResult();
        $array_of_counts = [];
        foreach ($supervisors as $super) {
            array_push($array_of_counts, $super->no_projects_supervised);
        }
        // Find the least value from an array
        $min_value = min($array_of_counts);
        //echo json_encode($min_value);
        // find the lowest supervisors' projects count value amongst all
        foreach ($supervisors as $super) {
            // assign project to a supervisor with the least projects' count
            if ($min_value === $super->no_projects_supervised) {
                $projectData['supervisor_id'] = $super->id;
                $new_value = $min_value + 1;
                $supervisor->where('id', $super->id);
                $supervisor->set('no_projects_supervised', $new_value);
                $supervisor->update();
                $projectData['status'] = 'approved';

                $project = new ProjectModel();

                // register project
                if ($project->insert($projectData)) {

                    $query = $db->query("SELECT * FROM supervisors WHERE user_id = $super->id;");
                    $row = $query->getRow();
                    $query2 = $db->query("SELECT * FROM users WHERE user_id = $row->user_id;");

                    // $response['status'] = "success";
                    // $response['message'] = $data["title"]." project is created, successfully and assigned to supervisor ".$query2->getRow()->user_name;
                    // echo json_encode($response);

                    $this->index();

                } else {
                    // returns success response message to a user
                    $response['status'] = "danger";
                    $response['message'] = "Failed to create project " . $data['title'];
                    echo json_encode($response);

                    $this->index();
                }
            }
        }
    }


    public function upload_index()
    {
        // fetch the uploaded files and phases and project names then list, download button
        
        $project = new ProjectModel();
        $myProject = $project->where('created_by', $_SESSION['user_id'])->get()->getResult();
        foreach ($myProject as $project){
            $data['id'] = $project->id;
            $data['title'] = $project->title;

            $project_attachment = new ProjectAttachmentModel();
            $data['details'] = $project_attachment->where('project_id', $project->id)->findAll();
        }


        // var_dump($data['title']);

        return view('Project/upload', $data);
    }

    public function uploadFile()
    {
        $projectAttachment = new ProjectAttachmentModel();
        $file = $this->request->getFile("projectFile");
        $phase = $this->request->getVar('phase');
        $project_id = $this->request->getVar('project_id');
        $data = [
            'name' => $file->getName(),
            'phase' => $phase,
            'project_id' => $project_id
        ];
        // save file details into db 
        if ($projectAttachment->insert($data)) {
            // move file into folder
            $file->move(WRITEPATH . 'uploads', $file->getName());
        }
    }

    public function chat_index()
    {
        return view('Project/chat');
    }
}
