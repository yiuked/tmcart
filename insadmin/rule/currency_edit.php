<?php
if(isset($_POST['sveCurrency']) && Tools::getRequest('sveCurrency')=='add')
{
	$currency = new Currency();
	$currency->copyFromPost();
	$currency->add();
	
	if(is_array($currency->_errors) AND count($currency->_errors)>0){
		$errors = $currency->_errors;
	}else{
		$_GET['id']	= $currency->id;
		echo '<div class="conf">创建对象成功</div>';
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new Currency($id);
}

if(isset($_POST['sveCurrency']) && Tools::getRequest('sveCurrency')=='edit')
{
	if(Validate::isLoadedObject($obj)){
		$obj->copyFromPost();
		$obj->update();
	}
	
	if(is_array($obj->_errors) AND count($obj->_errors)>0){
		$errors = $obj->_errors;
	}else{
		echo '<div class="conf">更新对象成功</div>';
	}
}
/** 输出错误信息 */
if (isset($errors)) {
  UIAdminAlerts::MError($errors);
}

/** 导航 */
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '货币', 'href' => 'index.php?rule=currency'));
$breadcrumb->add(array('title' => '编辑', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
    array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=currency', 'class' => 'btn-primary', 'icon' => 'level-up') ,
    array('type' => 'button', 'title' => '保存', 'id' => 'save-base-form', 'class' => 'btn-success', 'icon' => 'plus') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>
<script language="javascript">
	$("#save-currency-form").click(function(){
		$("#currency-form").submit();
	})
</script>
<?php
$form = new UIAdminEditForm('post', 'index.php?rule=currency_edit'. (isset($id) ? '&id=' . $id : ''), 'form-horizontal', 'currency-form');
$form->items = array(
    'name' => array(
        'title' => '货币名',
        'type' => 'text',
        'value' => isset($obj) ? $obj->name : Tools::Q('name'),
    ),
    'iso_code' => array(
        'title' => 'ISO代码',
        'type' => 'text',
        'value' => isset($obj) ? $obj->iso_code : Tools::Q('iso_code'),
    ),
    'iso_code_num' => array(
        'title' => 'ISO数字代码',
        'type' => 'text',
        'value' => isset($obj) ? $obj->iso_code_num : Tools::Q('iso_code_num'),
    ),
    'sign' => array(
        'title' => '货币符号',
        'type' => 'text',
        'value' => isset($obj) ? $obj->sign : Tools::Q('sign'),
    ),
    'conversion_rate' => array(
        'title' => '货币符号',
        'type' => 'text',
        'value' => isset($obj) ? $obj->conversion_rate : Tools::Q('conversion_rate'),
        'info' => '默认货币的汇率为1,其它货币是相对默认货币的转换率',
    ),
    'sign' => array(
        'title' => '货币符号',
        'type' => 'text',
        'value' => isset($obj) ? $obj->sign : Tools::Q('sign'),
    ),
    'format' => array(
        'title' => '货币显示格式',
        'type' => 'select',
        'value' => isset($obj) ? $obj->format : Tools::Q('format'),
        'option' => array(
            '1' => 'X0,000.00 (美元格式)',
            '2' => '0 000,00X (欧元格式)',
            '3' => 'X0.000,00',
            '4' => '0,000.00X',
            '5' => '0 000.00X',
        ),
    ),
    'saveCurrency' => array(
        'type' => 'hidden',
        'value' => isset($id) ? 'edit' : 'add',
    ),
);
echo UIViewBlock::area(array( 'title' => '编辑', 'body' => $form->draw()), 'panel');
