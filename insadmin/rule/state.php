<?php
if (Tools::G('delete') > 0) {
	$object = new State(intval(Tools::G('delete')));
	if (Validate::isLoadedObject($object)) {
		$object->delete();
	}
	
	if (is_array($object->_errors) AND count($object->_errors)>0) {
		$errors = $object->_errors;
	}else{
		UIAdminAlerts::conf('省/州已删除');
	}
} elseif(Tools::isSubmit('deleteItems')) {
	$select_cat = Tools::getRequest('categoryBox');
	$state	= new State();
		if ($state->deleteSelection($select_cat)) {
			UIAdminAlerts::conf('省/州已删除');
		}
} elseif(Tools::isSubmit('openSelected') OR Tools::isSubmit('closeSelected')) {
	$select_cat = Tools::P('categoryBox');
	$action		= Tools::isSubmit('subActiveON') ? 1 : 0;
	$object		= new State();
	if (is_array($select_cat)) {
		if ($object->statusSelection($select_cat,$action)) {
			UIAdminAlerts::conf('省/州已更新');
		}
	}
}

$table =  new UIAdminTable('state', 'State', 'id_state');
$table->header = array(
	array('sort' => false, 'isCheckAll' => 'itemsBox[]', 'name' => 'id_state'),
	array('name' => 'id_state', 'title' => 'ID', 'filter' => 'string'),
	array('name' => 'country', 'title' => '国家', 'filter' => 'string'),
	array('name' => 'name', 'title' => '省/州', 'filter' => 'string'),
	array('name' => 'iso_code', 'title' => 'ISO代码', 'filter' => 'string'),
	array('name' => 'active', 'title' => '状态', 'filter' => 'bool'),
	array('sort' => false, 'title' => '操作', 'class' => 'text-right', 'isAction'=> array( 'edit', 'delete')),
);

$filter = $table->initFilter();
$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'id_state';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'asc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= State::loadData($p, $limit, $orderBy, $orderWay, $filter);

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '省/州', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
	array('type' => 'a', 'title' => '新省/州', 'href' => 'index.php?rule=state_edit', 'class' => 'btn-success', 'icon' => 'plus') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
$btn_group = array(
	array('type' => 'button', 'title' => '删除选中', 'confirm' => '你确定要删除选中项?', 'name' => 'delSelected', 'class' => 'btn-danger', 'icon' => 'remove') ,
	array('type' => 'button', 'title' => '激活选中', 'name' => 'openSelected', 'class' => 'btn-default') ,
	array('type' => 'button', 'title' => '禁用选中', 'name' => 'closeSelected', 'class' => 'btn-default') ,
);
echo UIViewBlock::area(array('title' => '省/州', 'table' => $table, 'result' => $result, 'limit' => $limit, 'btn_groups' => $btn_group), 'table');
