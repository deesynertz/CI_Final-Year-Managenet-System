<?php

namespace App\Controllers;

use App\Models\ProjectAttachmentModel;

class Dashboard extends BaseController
{
	public function index()
	{
		$session = session();

		$model = new ProjectAttachmentModel();
    $data['PACount']  = $model->projects_attachments_count();

		// var_dump($data['PACount']);

		return view('Dashboard/index',  $data);
	}

	public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }

}