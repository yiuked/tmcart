<?php
if(isset($_POST['id_parent'])&&strlen(trim($_POST['content']))>5)
{
	$contact = new Contact();
	$contact->copyFromPost();
	if($contact->add()){
		$c = new Contact(Tools::getRequest('id_parent'));
		$c->active = 1;
		$c->update();
		$vars = array(
			'{name}'=>$cookie->name,
			'{subject}'=>$contact->subject,
			'{message}'=>$contact->content,
		);
		Mail::Send('replay',$c->subject,$vars,$c->email);
		if($c->id_user>0){
			Alert::Send($c->id_user,$contact->content);
		}
	}
	
	if(is_array($contact->_errors) AND count($contact->_errors)>0){
		$errors = $contact->_errors;
	}else{
		echo '<div class="conf">回复成功</div>';
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new Contact($id);
	$subs = $obj->getSubMessage();
	if($obj->id_user>0){
		$userAllContact = $obj->getContactByUser();
	}
}

require_once(_TM_ADMIN_DIR_.'/errors.php');
?>
<div class="path_bar">
  <div class="path_title">
    <h3> 
		<span style="font-weight: normal;" id="current_obj">
		<span class="breadcrumb item-1 ">留言<img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;"> </span> 
		<span class="breadcrumb item-2 ">编辑 </span> </span> 
	</h3>
    <div class="cc_button">
      <ul>
        <li> <a title="Save" href="#" class="toolbar_btn" id="desc-product-save"> <span class="process-icon-save "></span>
          <div>保存</div>
          </a> </li>
        <li> <a title="Back to list" href="javascript:history.back();" class="toolbar_btn" id="desc-product-back"> <span class="process-icon-back "></span>
          <div>返回列表</div>
          </a> </li>
      </ul>
    </div>
  </div>
</div>
<script language="javascript">
	$("#desc-product-save").click(function(){
		$("#contact_form").submit();
	})
</script>
<div class="mianForm">
  <fieldset>
	<legend> <img alt="CMS 分类" src="<?php echo $_tmconfig['tm_img_dir'];?>icon/category.png">内容</legend>
	<div class="contact">
		<b>游客昵称：</b>
		<?php if($obj->id_user==0){ ?>
		<?php echo $obj->name;?>
		<?php }else{ ?>
		<a href="index.php?rule=user_edit&id=<?php echo $obj->id_user;?>"><?php echo $obj->name;?><b>(注册用户)</b></a>
		<?php } ?>
		<br/>
		<b>邮箱：</b><?php echo $obj->email;?>
		<br/><br/><br/><br/>
		
	<?php if($obj->id_user==0){ ?>
		<b>发表于：</b><?php echo $obj->add_date;?>
		<br/>
		<b>主题：</b><?php echo $obj->subject;?>
		<br/>
		<b>内容：</b><br/><?php echo $obj->content;?>
		<hr>
		<?php foreach($subs as $sub){?>
		<div class="replay">
			<b>回复于：</b><?php echo $sub['add_date'];?>
			<br/>
			<b>内容：</b><br/><?php echo  $sub['content'];?>
			<hr />
		</div>
		<?php }?>
	<?php }else{ ?>
		<?php foreach($userAllContact as $row){ ?>
			<div class="demo clearfix">
				<span class="triangle"></span>
				<div align="left"><?php echo $row['add_date'];?></div>
				<div class="article"><?php echo $row['content'];?></div>
			</div>
			<?php 
			if(isset($row['reply'])){
			foreach($row['reply'] as $rep){?>
			<div class="demo clearfix fr">
				<span class="triangle right"></span>
				<div align="right"><?php echo $rep['add_date'];?></div>
				<div class="article"><?php echo $rep['content'];?></div>
			</div>
			<?php }
			}?>
		<?php }?>
	<?php } ?>
	<form enctype="multipart/form-data" method="post" action="index.php?rule=contact_edit<?php echo isset($id)?'&id='.$id:''?>" class="defaultForm admincontactcontent" id="contact_form" name="example">
				<input type="hidden" name="name" value="<?php echo $obj->name;?>" />
				<input type="hidden" name="id_user" value="<?php echo (int)$obj->id_user;?>" />
				<input type="hidden" name="email" value="<?php echo $obj->email;?>" />
				<input type="hidden" name="subject" value="<?php echo $obj->subject;?>" />
				<input type="hidden" name="id_parent" value="<?php echo $obj->id_contact;?>" />
				<br/>
				<textarea name="content" id="content" style="width:600px; height:200px;"></textarea>
	</form>
		</div>
  </fieldset>
</div>
