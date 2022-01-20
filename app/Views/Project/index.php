<?php
require_once 'header.php';
require_once 'sidebar.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="box-body" id="box-body">
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-check"></i> Welcome, to Final Year Project Monitoring and Evaluation!</h4>
      <strong><?php echo ucfirst($_SESSION['user_name']); ?></strong>
    </div>
  </div>

  <section class="content-header">
    <h1> Project <small>Control panel</small> </h1>
    <ol class="breadcrumb">
      <li>Dashboard</li>
      <li class="active">Project</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Project Detail Overview</h3>
        <div class="box-tools">
          <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
          </div>
        </div>
      </div>

      <div class="box-body table-responsive">
        <?php if (!empty($projects)) : ?>
          <table class="table table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Supervisor Name</th>
                <th>Aprroved Date</th>
                <th>Status</th>
                <th>Title</th>
              </tr>
            </thead>

            <tbody>
              <?php foreach ($projects as $project) : ?>
                <tr>
                  <td><?php echo $project->id; ?></td>
                  <td><?php echo $project->user_name; ?></td>
                  <td><?php echo $project->created_at; ?></td>
                  <td><span class="label label-success"><?php echo $project->status; ?></span></td>
                  <td><?php echo $project->title; ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else : ?>
          <div class="col-12">
            <p class="ml-5"><strong>No Project Details Found! <a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal" class="text-info ">click here to add project</a> </strong></p>

          </div>
        <?php endif; ?>
      </div>
    </div>
    <div class="clearfix"></div>

    <?php if (!empty($projectAtts)) : ?>
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Project Evaluation</h3>
        </div>
        <div class="box-body">
          <table class="table table-striped">

            <tr>
              <th style="width: 10px">#</th>
              <th>Project</th>
              <th>Progress</th>
              <th style="width: 40px">Marks</th>
            </tr>
            <?php foreach ($projectAtts as $attchmt) : ?>
              <tr>
                <td><?php echo $attchmt->phase;?> .</td>
                <td>Phase <?php echo $attchmt->phase;?></td>
                <td>

                <?php $bar = ($attchmt->phase == 1) ? 25: 
                    (($attchmt->phase == 2) ? 50 : (($attchmt->phase == 3) ? 75 : 100));?>

                <?php $bg_color = ($attchmt->phase == 1) ? 'bg-red': 
                    (($attchmt->phase == 2) ? 'bg-yellow' : (($attchmt->phase == 3) ? 'bg-blue' : 'bg-green'));?>

                  <div class="progress progress-xs">
                    <div class="progress-bar <?php echo ($attchmt->phase == 1) ? 'progress-bar-danger': 
                    (($attchmt->phase == 2) ? 'progress-bar-yellow' : (($attchmt->phase == 3) ? 'progress-bar-info' : 'progress-bar-success' ));?>" style="width: <?php echo $bar;?>%"></div>
                  </div>
                </td>
                <td><span class="badge <?php echo $bg_color;?>"><?php echo $bar;?>%</span></td>
              </tr>
            <?php endforeach; ?>

            <!--<tr>
              <td>2.</td>
              <td>Phase II</td>
              <td>
                <div class="progress progress-xs">
                  <div class="progress-bar progress-bar-yellow" style="width: 0%"></div>
                </div>
              </td>
              <td><span class="badge bg-yellow">0%</span></td>
            </tr>
            <tr>
              <td>3.</td>
              <td>Phase III</td>
              <td>
                <div class="progress progress-xs progress-striped active">
                  <div class="progress-bar progress-bar-primary" style="width: 0%"></div>
                </div>
              </td>
              <td><span class="badge bg-light-blue">0%</span></td>
            </tr>
            <tr>
              <td>4.</td>
              <td>Phase IV</td>
              <td>
                <div class="progress progress-xs progress-striped active">
                  <div class="progress-bar progress-bar-success" style="width: 0%"></div>
                </div>
              </td>
              <td><span class="badge bg-green">0%</span></td>
            </tr> -->
          </table>
        </div>

      </div>
    <?php endif; ?>
  </section>
</div>

<?php
require_once 'footer.php';
?>


<!-- MODAL -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Register New Project</h4>
      </div>
      <div class="modal-body">
        <form method="post" id="form-project" action="/project-register">
          <div class="form-group">
            <label for="recipient-name" class="control-label">Title</label>
            <input type="text" class="form-control" id="title" name="title">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="control-label">Language</label>
            <select id="language" name="language" class="form-control">
              <option value="PHP">Php</option>
              <option value="PYTHON">Python</option>
              <option value="JAVA">Java</option>
              <option value="C#">C#</option>
              <option value="JAVASCRIPT">Javascript</option>
            </select>
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">Abstract</label>
            <textarea class="form-control" id="abstract" name="abstract"></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>