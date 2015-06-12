<?php
define('PRO_IMPORT_DIR',_TM_ADMIN_DIR_.'/upload/import/');

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
require_once(dirname(__FILE__).'/../errors.php');
?>

<div class="path_bar">
  <div class="path_title">
    <h3> <span style="font-weight: normal;" id="current_obj"> <span class="breadcrumb item-1 ">数据<img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;"> </span> <span class="breadcrumb item-2 ">导入</span> </span> </h3>
  </div>
</div>

<div class="mianForm">
  <form enctype="multipart/form-data" method="post" action="index.php?rule=import" class="defaultForm" id="import_uploaed_form" name="import_uploaed_form">
    <fieldset class="small">
    <legend> <img alt="CMS 分类" src="<?php echo $_tmconfig['ico_dir'];?>category.png">上传CSV文件</legend>
    <label>文件: </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
        <input type="file" value=""  name="csv_name">
      </div>
      <div class="clear"></div>
    </div>
    <label>文件名: </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
        <input type="text" value="<?php echo Tools::getRequest('file_name');?>"  name="file_name">
		<p class="preference_description">用于区别上传后的文件，若不填则自动生成以时间的文件名,<b>如：test</b></p>
      </div>
      <div class="clear"></div>
    </div>
	<div class="margin-form">
		<input type="submit" class="button" value="上传" name="updateCSV">
	</div>
    </fieldset>
  </form>
  <br/><br/>
  <form enctype="multipart/form-data" method="post" action="index.php?rule=import" class="defaultForm" id="import_form" name="import_form">
    <fieldset class="small">
    <legend> <img alt="CMS 分类" src="<?php echo $_tmconfig['ico_dir'];?>category.png">导入产品</legend>
    <label>选择上传文件: </label>
    <div class="margin-form">
	  <?php
	  	$csvs = glob(PRO_IMPORT_DIR.'*.csv');
	  ?>
      <div style="display:block; float: left;">
        <select id="import_file" name="import_file" size="5">
			<option value="NULL" selected="selected">--选择文件--</option>
			<?php foreach($csvs as $csv){?>
			<option value="<?php echo basename($csv);?>"><?php echo basename($csv);?></option>
			<?php }?>
		</select>
		<p class="preference_description">若手动复制文件到目录，请确保文件为csv格式，且后缀csv为小写</p>
      </div>
      <div class="clear"></div>
    </div>
	<div class="margin-form">
		<input type="submit" class="button" value="导入" name="importCSV">
	</div>
    </fieldset>
  </form>
</div>
