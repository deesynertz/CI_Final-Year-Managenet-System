<?php
require_once 'header.php';
require_once 'sidebar.php';
?>

<div class="content-wrapper">
    
<section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-8 col-md-offset-2">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Upload Project Files</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="/upload" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputPassword1">Choose phase</label>
                  <select name="phase" class="form-control">
                    <option value="1">phase 1</option>
                    <option value="2">phase 2</option>
                    <option value="3">phase 3</option>
                    <option value="4">phase 4</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">File input</label>
                  <input type="file" name="projectFile"/>
                  <input type="hidden" name="project_id" value="<?php echo $id;?>"/>
                </div>
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary" style="width:100%;">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.box -->


          <?php if(!empty($details)) :?>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Project File</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-condensed">
                <tr>
                  <th style="width: 10px">
                Phase</th>
                  <th>File</th>
                  <th>Project Title</th>
                  <th style="width: 40px">Marks</th>
                </tr>
                <?php if(isset($details)): ?>
                  <?php foreach($details as $detail):?>
                    <tr>
                      <td><?php echo $detail['phase']; ?></td>
                      <td><a href="http://"><?php echo $detail['name']; ?></a> </td>
                      <td><?php echo $title; ?></td>
                      <td>3%</td>
                    </tr>
                  <?php endforeach; ?>
               <?php endif; ?>
              </table>
            </div>
          </div>
          <?php endif;?>
          <!-- /.box -->
        </div>
</section>
</div>



<?php
require_once 'footer.php';
?> 