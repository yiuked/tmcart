<?php
if(Tools::P('content')) {
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
		Mail::Send('replay', $c->subject, $vars, $c->email);
		if($c->id_user>0){
			Alert::Send($c->id_user, $contact->content);
		}
	}
	
	if(is_array($contact->_errors) AND count($contact->_errors)>0){
		$errors = $contact->_errors;
	}else{
		echo '<div class="conf">回复成功</div>';
	}
}

if(isset($_GET['id'])){
	$id  = (int) $_GET['id'];
	$obj = new Contact($id);
	$subs = $obj->getSubMessage();
	if($obj->id_user>0){
		$userAllContact = $obj->getContactByUser();
	}
}

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '客户留言', 'active' => true));
$bread = $breadcrumb->draw();
$btn_groups = array(
	array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=contact', 'class' => 'btn-primary', 'icon' => 'level-up') ,
	array('type' => 'button', 'title' => '保存', 'id' => 'save-contact-form', 'class' => 'btn-success', 'icon' => 'save') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_groups), 'breadcrumb');

?>
<script language="javascript">
	$("#save-contact-form").click(function(){
		$("#contact-form").submit();
	})
</script>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">客户回复内容</div>
			<div class="panel-body">
				<form method="post" action="index.php?rule=contact_edit<?php echo isset($id) ? '&id=' . $id : ''; ?>" class="form-horizontal" id="contact-form">
					<div class="form-group">
						<label class="col-sm-2 control-label">游客昵称</label>
						<div class="col-sm-10">
							<p class="form-control-static">
								<?php if($obj->id_user==0){ ?>
									<?php echo $obj->name;?>
								<?php }else{ ?>
									<a href="index.php?rule=user_edit&id=<?php echo $obj->id_user;?>"><?php echo $obj->name;?> <b>(注册用户)</b></a>
								<?php } ?>
							</p>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">游客昵称</label>
						<div class="col-sm-10">
							<p class="form-control-static"><?php echo $obj->email;?></p>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">内容</label>
						<div class="col-sm-10">
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
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">回复</label>
						<div class="col-sm-8">
							<textarea name="content" id="content" class="form-control"></textarea>
						</div>
					</div>
					<input type="hidden" name="name" value="<?php echo $obj->name;?>" />
					<input type="hidden" name="id_user" value="<?php echo (int)$obj->id_user;?>" />
					<input type="hidden" name="email" value="<?php echo $obj->email;?>" />
					<input type="hidden" name="subject" value="<?php echo $obj->subject;?>" />
					<input type="hidden" name="id_parent" value="<?php echo $obj->id_contact;?>" />
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-save" aria-hidden="true"></span>保存</button>
						</div>
					</div>
			</form>
		</div>
		</div>
  </div>
</div>
