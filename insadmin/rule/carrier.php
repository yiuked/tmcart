<?php
if(intval(Tools::getRequest('delete'))>0){
	$object = new Carrier(intval(Tools::getRequest('delete')));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">删除对象成功</div>';
	}
}
if(isset($_POST['setDefaultCarrierID']))
{
	if($def_carrier_id = Tools::getRequest('TM_DEFAULT_CARRIER_ID'))
		Configuration::updateValue('TM_DEFAULT_CARRIER_ID',$def_carrier_id);
	if($enjoy_freeshipping = Tools::getRequest('ENJOY_FREE_SHIPPING'))
		Configuration::updateValue('ENJOY_FREE_SHIPPING',$enjoy_freeshipping);
	echo '<div class="conf">更新成功</div>';
}



$table =  new UIAdminTable('carrier', 'Carrier', 'id_carrier');
$table->header = array(
	array('sort' => false, 'isCheckAll' => 'itemsBox[]','name' => 'id_carrier'),
	array('name' => 'id_carrier','title' => 'ID','filter' => 'string'),
	array('name' => 'name','title' => '配送商','filter' => 'string'),
	array('sort' => false ,'name' => 'image_small','isImage' => true,'title' => '图片'),
	array('name' => 'description','title' => '描述','filter' => 'string'),
	array('name' => 'shipping','title' => '运费','filter' => 'string'),
	array('name' => 'active','title' => '状态','filter' => 'bool'),
	array('sort' => false, 'title' => '操作', 'class' => 'text-right', 'isAction'=> array( 'edit', 'delete')),
);

$filter = $table->initFilter();
$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'id_carrier';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'desc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= Carrier::getEntity($p, $limit, $orderBy, $orderWay, $filter);

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '物流', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
	array('type' => 'a', 'title' => '新物流', 'href' => 'index.php?rule=carrier_edit', 'class' => 'btn-success', 'icon' => 'plus') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
echo UIViewBlock::area(array('title' => '物流', 'table' => $table, 'result' => $result, 'limit' => $limit), 'table');


?>
<?php
$form = new UIAdminEditForm('post', 'index.php?rule=carrier', 'form-horizontal', 'address-form');
$carriers = array();
foreach($result['entitys'] as $car) {
	$carriers[$car['id_carrier']] = $car['name'];
}

$form->items = array(
	'TM_DEFAULT_CARRIER_ID' => array(
		'title' => '默认物流',
		'type' => 'select',
		'value' => Configuration::get('TM_DEFAULT_CARRIER_ID'),
		'option' => $carriers,
	),
	'ENJOY_FREE_SHIPPING' => array(
		'title' => '满多少金额免运费',
		'type' => 'text',
		'value' => Configuration::get('ENJOY_FREE_SHIPPING'),
	),
	'setDefaultCarrierID' => array(
		'title' => '保存',
		'type' => 'submit',
		'class' => 'btn-success',
		'icon' => 'glyphicon-save'
	),
);
echo UIViewBlock::area(array('col' => 'col-md-12', 'title' => '默认配置', 'body' => $form->draw()), 'panel');
?>
