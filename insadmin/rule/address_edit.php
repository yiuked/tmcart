<?php
if(isset($_POST['sveAddress']) && Tools::getRequest('sveAddress') == 'add')
{
	$address = new Address();
	$address->copyFromPost();
	$address->add();
	
	if(is_array($address->_errors) AND count($address->_errors) > 0){
		$errors = $address->_errors;
	}else{
		$_GET['id']	= $address->id;
		UIAdminAlerts::conf('地址已添加');
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new Address($id);
}

if(isset($_POST['sveAddress']) && Tools::getRequest('sveAddress') == 'edit')
{
	if(Validate::isLoadedObject($obj)){
		$obj->copyFromPost();
		$obj->update();
	}
	
	if(is_array($obj->_errors) AND count($obj->_errors) > 0){
		$errors = $obj->_errors;
	}else{
		UIAdminAlerts::conf('地址已更新');
	}
}

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '地址', 'href' => 'index.php?rule=address'));
$breadcrumb->add(array('title' => '编辑', 'active' => true));
$bread = $breadcrumb->draw();

$btn_group = array(
	array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=address', 'class' => 'btn-primary', 'icon' => 'level-up') ,
	array('type' => 'a', 'title' => '保存', 'id' => 'save-address', 'href' => '#', 'class' => 'btn-success', 'icon' => 'save') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#save-address').click(function(){
			$('#address-form').submit();
		})
		ajaxStates ();
		$('#id_country').change(function() {
			ajaxStates ();
		});
		function ajaxStates ()
		{
			var id_state = <?php echo intval(isset($obj) ? $obj->id_state : Tools::Q('id_state'));?>;
			$.ajax({
				url: "public/ajax.php",
				cache: false,
				data: "ajaxStates=1&id_country=" + $('#id_country').val() + "&id_state=" + id_state,
				success: function(html)
				{
					if (html == 'false')
					{
						$("#contains_states").fadeOut();
					}
					else
					{
						$("#id_state").html(html);
						$("#contains_states").fadeIn();
					}
				}
			});
		};
	});
</script>
<?php
$form = new UIAdminEditForm('post', 'index.php?rule=address_edit'. (isset($id) ? '&id=' . $id : ''), 'form-horizontal', 'address-form');
$result = Country::getEntity(1,500);
$countrys = array();
foreach($result['entitys'] as $country) {
	$countrys[$country['id_country']] = $country['name'];
}

$form->items = array(
	'name' => array(
		'title' => '名称',
		'type' => 'text',
		'value' => isset($obj) ? $obj->name : Tools::Q('name'),
	),
	'address' => array(
		'title' => '地址',
		'type' => 'text',
		'value' => isset($obj) ? $obj->address : Tools::Q('address'),
	),
	'id_country' => array(
		'title' => '国家',
		'type' => 'select',
		'id' => 'id_country',
		'value' => isset($obj) ? $obj->id_country : Tools::Q('id_country'),
		'option' => $countrys,
	),
	'id_state' => array(
		'title' => '省/州',
		'id' => 'id_state',
		'type' => 'select',
		'value' => isset($obj) ? $obj->id_state : Tools::Q('id_state'),
	),
	'city' => array(
		'title' => '城市',
		'type' => 'text',
		'value' => isset($obj) ? $obj->city : Tools::Q('city'),
	),
	'postcode' => array(
		'title' => '邮编',
		'type' => 'text',
		'value' => isset($obj) ? $obj->postcode : Tools::Q('postcode'),
	),
	'phone' => array(
		'title' => '电话',
		'type' => 'text',
		'value' => isset($obj) ? $obj->phone : Tools::Q('phone'),
	),
	'sveAddress' => array(
		'type' => 'hidden',
		'value' => isset($id) ? 'edit' : 'add',
	),
);
echo UIViewBlock::area(array('col' => 'col-md-12', 'title' => '编辑', 'body' => $form->draw()), 'panel');
?>