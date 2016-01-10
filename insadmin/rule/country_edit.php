<?php
if(Tools::P('saveCountry') == 'add')
{
	$orderstatus = new Country();
	$orderstatus->copyFromPost();
	$orderstatus->add();
	
	if(is_array($orderstatus->_errors) AND count($orderstatus->_errors)>0){
		$errors = $orderstatus->_errors;
	}else{
		$_GET['id']	= $orderstatus->id;
      UIAdminAlerts::conf('国家已添加');
	}
}

if(isset($_GET['id'])){
	$id  = (int) $_GET['id'];
	$obj = new Country($id);
}

if(Tools::P('saveCountry') == 'edit')
{
	if(Validate::isLoadedObject($obj)){
		$obj->copyFromPost();
		$obj->update();
	}
	
	if(is_array($obj->_errors) AND count($obj->_errors)>0){
		$errors = $obj->_errors;
	}else{
		UIAdminAlerts::conf('国家已更新');
	}
}
if (isset($errors)) {
  UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '国家', 'href' => 'index.php?rule=country'));
$breadcrumb->add(array('title' => '编辑', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
    array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=country', 'class' => 'btn-primary', 'icon' => 'level-up') ,
    array('type' => 'a', 'title' => '保存', 'id' => 'save-country-form', 'href' => '#', 'class' => 'btn-success', 'icon' => 'save') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>

<script language="javascript">
	$("#save-country-form").click(function(){
		$("#country-form").submit();
	})
</script>
<?php
$form = new UIAdminEditForm('post', 'index.php?rule=country_edit'. (isset($id) ? '&id=' . $id : ''), 'form-horizontal', 'country-form');
$form->items = array(
    'name' => array(
        'title' => '名称',
        'type' => 'text',
        'value' => isset($obj) ? $obj->name : Tools::Q('name'),
    ),
    'need_state' => array(
        'title' => '州/省',
        'type' => 'bool',
        'value' => isset($obj) ? $obj->need_state : Tools::Q('need_state'),
    ),
    'iso_code' => array(
        'title' => 'ISO代码',
        'type' => 'text',
        'value' => isset($obj) ? $obj->iso_code : Tools::Q('iso_code'),
    ),
    'active' => array(
        'title' => '状态',
        'type' => 'bool',
        'value' => isset($obj) ? $obj->active : Tools::Q('active'),
    ),
    'saveCountry' => array(
        'type' => 'hidden',
        'value' => isset($id) ? 'edit' : 'add',
    ),
);
echo UIViewBlock::area(array('col' => 'col-md-12', 'title' => '编辑', 'body' => $form->draw()), 'panel');
