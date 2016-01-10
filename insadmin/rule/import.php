<?php
define('PRO_IMPORT_DIR',ADMIN_DIR.'/upload/import/');

if(Tools::isSubmit('updateCSV'))
{
	$pathinfo = pathinfo($_FILES['csv_name']['name']);
	$filename = isset($_POST['file_name'])?Tools::getRequest('file_name').'.csv':$pathinfo['basename'];
	$csvfile  = PRO_IMPORT_DIR.$filename;
	
	if(strtolower($pathinfo['extension'])=='csv')
	{
		if(move_uploaded_file($_FILES['csv_name']['tmp_name'],$csvfile))
			echo '<div class="conf">上传文件成功!</div>';
	}	
}

if(Tools::isSubmit('importCSV'))
{
	$import = new Import();
	if($import->vlidateFile(PRO_IMPORT_DIR.Tools::getRequest('import_file')))
		$import->start();
	else
		$errors[] = '导入时验证文件失败!';
}
if (isset($errors)) {
  UIAdminAlerts::MError($errors);
}
?>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="col-md-6">
          <?php
          $breadcrumb = new UIAdminBreadcrumb();
          $breadcrumb->home();
          $breadcrumb->add(array('title' => '批量导入产品', 'active' => true));
          echo $breadcrumb->draw();
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        上传文件
      </div>
      <div class="panel-body">
        <form enctype="multipart/form-data" method="post" action="index.php?rule=import" class="form-horizontal" id="import_uploaed_form" >
          <div class="form-group">
            <label for="csv_name" class="col-md-2 control-label">CSV文件</label>
            <div class="col-md-5">
              <input type="file" value=""  name="csv_name">
            </div>
          </div>
          <div class="form-group">
            <label for="file_name" class="col-md-2 control-label">文件名</label>
            <div class="col-md-5">
              <input type="text" value="<?php echo Tools::getRequest('file_name');?>"  name="file_name" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-5 col-md-offset-2">
              <button type="submit"  class="btn btn-success" ><span aria-hidden="true" class="glyphicon glyphicon-open"></span> 上传</button>
            </div>
          </div>
        </form>
      </div>
    </div>
   </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        导入文件
      </div>
      <div class="panel-body">
        <form method="post" action="index.php?rule=import" class="form-horizontal" id="import_form" >
          <div class="form-group">
            <label for="file_name" class="col-md-2 control-label">文件名</label>
            <div class="col-md-5">
              <?php
              $csvs = glob(PRO_IMPORT_DIR.'*.csv');
              ?>
              <select id="import_file" name="import_file" size="5" class="form-control">
                <option value="NULL" selected="selected">--选择文件--</option>
                <?php foreach($csvs as $csv){?>
                  <option value="<?php echo basename($csv);?>"><?php echo basename($csv);?></option>
                <?php }?>
              </select>
              <p class="text-info">若手动复制文件到目录，请确保文件为csv格式，且后缀csv为小写</p>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-5 col-md-offset-2">
              <button type="submit"  class="btn btn-success" ><span aria-hidden="true" class="glyphicon glyphicon-open"></span> 导入</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
