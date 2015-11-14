<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new User(intval(Tools::getRequest('delete')));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">删除对象成功</div>';
	}
}elseif(Tools::isSubmit('subDelete')){
	$select_cat = Tools::getRequest('categoryBox');
	$user	= new User();
	if($user->deleteSelection($select_cat))
		echo '<div class="conf">删除对象成功</div>';

}elseif(intval(Tools::getRequest('toggleStatus'))>0){
	$object = new User(intval(Tools::getRequest('toggleStatus')));
	if(Validate::isLoadedObject($object)){
		$object->toggleStatus();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新对象状态成功</div>';
	}
}

$filter	 = $cookie->getFilter('user',array('id_user','name','email','active'));
if(Tools::isSubmit('submitResetUser')){
	$cookie->unsetFilter('user',array('id_user','name','email','active'));
	$filter = array();
}

$orderBy 	= $cookie->getPost('orderby') ? $cookie->getPost('orderby') : 'id_user';
$orderWay 	= $cookie->getPost('orderway') ? $cookie->getPost('orderway') : 'ASC';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::getRequest('p') ? Tools::getRequest('p'):1;

$result  	= User::getEntitys(false,$p,$limit,$orderBy,$orderWay,$filter);
require_once(dirname(__FILE__).'/../errors.php');
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="col-md-6">
					<?php
					$breadcrumb = new UIAdminBreadcrumb();
					$breadcrumb->home();
					$breadcrumb->add(array('title' => '用户', 'active' => true));
					echo $breadcrumb->draw();
					?>
				</div>
				<div class="col-md-6">
					<div class="btn-group save-group pull-right" role="group">
						<a href="index.php?rule=user_edit"  class="btn btn-success" id="submit-form"><span aria-hidden="true" class="glyphicon glyphicon-plus"></span> 新用户</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				用户列表
			</div>
			<div class="panel-body">
				<form class="form" method="post" action="index.php?rule=user">
					<?php
						$table =  new UIAdminTable();
						$table->rule = 'user';
						$table->data = $result['entitys'];
						$table->identifier = 'id_user';
						$table->className = 'User';
						$table->view = false;
						$table->header = array(
							array('isCheckAll' => 'categoryBox[]','name' => 'id_user'),
							array('sort' => true,'name' => 'id_user','title' => 'ID','filter' => 'string'),
							array('sort' => true,'name' => 'first_name','title' => '姓','filter' => 'string'),
							array('sort' => true,'name' => 'last_name','title' => '名','filter' => 'string'),
							array('sort' => true,'name' => 'email','title' => '邮箱','filter' => 'string'),
							array('sort' => true,'name' => 'active','title' => '状态','filter' => 'bool'),
							array('sort' => true,'name' => 'upd_date','title' => '最后登录'),
							array('sort' => true,'name' => 'add_date','title' => '注册时间'),
							array('title' => '操作','align' => 'text-right','filter_action'=> true),
						);
						echo $table->draw();
					?>
					<div class="row">
						<div class="col-md-4">
							<div class="btn-group" role="group" >
								<button type="submit" class="btn btn-default" onclick="return confirm('你确定要删除选中项目?');" name="subDelete">批量删除</button>
								<button type="submit" class="btn btn-default" name="subActiveON">批量启用</button>
								<button type="submit" class="btn btn-default" name="subActiveOFF">批量关闭</button>
							</div>
						</div>
						<div class="col-md-6">
							<?php
							$pagination = new UIAdminPagination($result['total'],$limit);
							echo $pagination->draw();
							?>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>