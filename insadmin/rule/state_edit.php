<?php
if(Tools::P('saveState') == 'add')
{
	$state = new State();
  $state->copyFromPost();
  $state->add();
	
	if(is_array($state->_errors) AND count($state->_errors)>0){
		$errors = $state->_errors;
	}else{
		$_GET['id']	= $state->id;
        UIAdminAlerts::conf('省/州已添加');
	}
}

if(isset($_GET['id'])){
	$id  = (int) $_GET['id'];
	$obj = new State($id);
}

if(Tools::P('saveState') == 'edit')
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
$breadcrumb->add(array('title' => '省/州', 'href' => 'index.php?rule=state'));
$breadcrumb->add(array('title' => '编辑', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
    array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=state', 'class' => 'btn-primary', 'icon' => 'level-up') ,
    array('type' => 'a', 'title' => '保存', 'id' => 'save-state-form', 'href' => '#', 'class' => 'btn-success', 'icon' => 'save') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>
<script language="javascript">
	$("#save-state-form").click(function(){
		$("#state-form").submit();
	})
</script>
<?php
$form = new UIAdminEditForm('post', 'index.php?rule=state_edit'. (isset($id) ? '&id=' . $id : ''), 'form-horizontal', 'state-form');
$result = Country::loadData(1,500);
$countrys = array();
foreach($result['items'] as $country) {
  $countrys[$country['id_country']] = $country['name'];
}

$form->items = array(
    'name' => array(
        'title' => '名称',
        'type' => 'text',
        'value' => isset($obj) ? $obj->name : Tools::Q('name'),
    ),
    'id_country' => array(
        'title' => '国家',
        'type' => 'select',
        'value' => isset($obj) ? $obj->id_country : Tools::Q('id_country'),
        'option' => $countrys,
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
    'saveState' => array(
        'type' => 'hidden',
        'value' => isset($id) ? 'edit' : 'add',
    ),
);
echo UIViewBlock::area(array('col' => 'col-md-12', 'title' => '编辑', 'body' => $form->draw()), 'panel');