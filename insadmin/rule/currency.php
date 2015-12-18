<?php

if(Tools::G('delete') > 0){
	$object = new Currency(intval(Tools::G('delete')));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		UIAdminAlerts::conf('货币已删除');
	}
}

if(Tools::isSubmit('saveDefault'))
{
	if($id_currency_default = Tools::P('ID_CURRENCY_DEFAULT')){
		Configuration::updateValue('ID_CURRENCY_DEFAULT', $id_currency_default);
		UIAdminAlerts::conf('默认货币已更新');
	}
}

echo UIAdminDndTable::loadHead();
$table = new UIAdminDndTable('currency',  'Currency', 'id_currency');
$table->addAttribte('id', 'currency');
$table->header = array(
	array('sort' => false ,'isCheckAll' => 'itemsBox[]'),
	array('name' => 'id_currency','title' => 'ID','filter' => 'string'),
	array('name' => 'name','title' => '名称','filter' => 'string'),
	array('name' => 'conversion_rate','title' => '汇率','filter' => 'string'),
	array('name' => 'iso_code','title' => 'ISO代码','filter' => 'string'),
	array('name' => 'sign','title' => '货币符号','filter' => 'string'),
	array('name' => 'active','title' => '状态','filter' => 'bool'),
	array('name' => 'position','title' => '排序'),
	array('name' => 'add_date','title' => '添加时间'),
	array('sort' => false ,'title' => '操作', 'class' => 'text-right', 'isAction'=> array( 'edit', 'delete')),
);
$filter = $table->initFilter();
$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'position';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'asc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= Currency::loadData($p, $limit, $orderBy, $orderWay, $filter);

/** 输出错误信息 */
if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

/** 导航 */
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '系统设置', 'active' => true));
$breadcrumb->add(array('title' => '基本设置', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
	array('type' => 'a', 'title' => '新货币', 'href' => 'index.php?rule=currency_edit', 'class' => 'btn-success', 'icon' => 'plus') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');


/** 输出列表 */
echo UIViewBlock::area(array('title' => '货币', 'table' => $table, 'result' => $result, 'limit' => $limit), 'table');
?>
<?php
$form = new UIAdminEditForm('post', 'index.php?rule=currency', 'form-horizontal', 'base-form');
$currencys = array();
foreach($result['items'] as $currency) {
	$currencys[$currency['id_currency']] = $currency['name'];
}

$form->items = array(
	'ID_CURRENCY_DEFAULT' => array(
		'title' => '默认货币',
		'type' => 'select',
		'value' => Configuration::get('ID_CURRENCY_DEFAULT'),
		'option' => $currencys,
	),
	'saveDefault' => array(
		'type' => 'submit',
		'class' => 'btn-success',
		'icon' => 'save',
		'title' => '保存',
	),
);
echo UIViewBlock::area(array('title' => '默认货币', 'body' => $form->draw()), 'panel');
?>
