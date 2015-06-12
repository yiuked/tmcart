<?php
if(isset($_POST['sveAddress']) && Tools::getRequest('sveAddress')=='add')
{
	$address = new Address();
	$address->copyFromPost();
	$address->add();
	
	if(is_array($address->_errors) AND count($address->_errors)>0){
		$errors = $address->_errors;
	}else{
		$_GET['id']	= $address->id;
		echo '<div class="conf">创建对象成功</div>';
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new Address($id);
}

if(isset($_POST['sveAddress']) && Tools::getRequest('sveAddress')=='edit')
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
require_once(_TM_ADMIN_DIR_.'/errors.php');
?>

<div class="path_bar">
  <div class="path_title">
    <h3> <span style="font-weight: normal;" id="current_obj"> <span class="breadcrumb item-1 ">编辑地址</span> </h3>
    <div class="cc_button">
      <ul>
        <li> <a title="Save" href="#" class="toolbar_btn" id="desc-base-save"> <span class="process-icon-save "></span>
          <div>保存</div>
          </a> </li>
        <li> <a title="Back to list" href="javascript:history.back();" class="toolbar_btn" id="desc-base-back"> <span class="process-icon-back "></span>
          <div>返回列表</div>
          </a> </li>
      </ul>
    </div>
  </div>
</div>
<script language="javascript">
	$("#desc-base-save").click(function(){
		$("#address_form").submit();
	})
</script>
<div class="mianForm">
  <form enctype="multipart/form-data" method="post" action="index.php?rule=address_edit&id=<?php echo $id;?>" class="defaultForm admincmscontent" id="address_form" name="example">
    <fieldset>
    <legend> <img alt="地址" src="<?php echo $_tmconfig['ico_dir'];?>category.png">地址</legend>
    <label>姓:</label>
    <div class="margin-form">
      <input type="text" name="first_name" value="<?php echo $obj->first_name;?>">
	  <div class="clear"></div>
    </div>
    <label>名:</label>
    <div class="margin-form">
      <input type="text" name="last_name" value="<?php echo $obj->last_name;?>">
	  <div class="clear"></div>
    </div>
    <label>地址:</label>
    <div class="margin-form">
      <input type="text" name="address" value="<?php echo $obj->address;?>" size="50">
	  <div class="clear"></div>
    </div>
    <script type="text/javascript">
		$(document).ready(function(){
				ajaxStates ();
				$('#id_country').change(function() {
					ajaxStates ();
					});
				function ajaxStates ()
				{
					$.ajax({
						url: "public/ajax.php",
						cache: false,
						data: "ajaxStates=1&id_country="+$('#id_country').val()+"&id_state="+$('#id_state').val(),
						success: function(html)
							{
								if (html == 'false')
								{
									$("#contains_states").fadeOut();
									$('#id_state option[value=0]').attr("selected", "selected");
								}
								else
								{
									$("#id_state").html(html);
									$("#contains_states").fadeIn();
									$('#id_state option[value=18]').attr("selected", "selected");
								}
							}
						}); 	
				  }; 
			}); 
	</script>
    <label>国家:</label>
    <?php
					$countrys = Country::getEntity(true,1,500);
				?>
    <div class="margin-form">
      <select id="id_country" name="id_country">
        <option value="NULL">--选择--</option>
        <?php foreach($countrys['entitys'] as $country){?>
        <option value="<?php echo $country['id_country'];?>" <?php echo $obj->id_country==$country['id_country']?'selected="selected"':''?>><?php echo $country['name'];?></option>
        <?php }?>
      </select>
	  <div class="clear"></div>
    </div>
	<div id="contains_states" style="display: none;">
		<label>州/省:</label>
		<div class="margin-form">
		  <select id="id_state" name="id_state"></select>
		  <div class="clear"></div>
		</div>
	</div>
    <label>城市:</label>
    <div class="margin-form">
      <input type="text" name="city" value="<?php echo $obj->city;?>" size="30">
	  <div class="clear"></div>
    </div>
    <label>邮编:</label>
    <div class="margin-form">
      <input type="text" name="postcode" value="<?php echo $obj->postcode;?>">
	  <div class="clear"></div>
    </div>
    <label>电话:</label>
    <div class="margin-form">
      <input type="text" name="phone" value="<?php echo $obj->phone;?>">
	  <div class="clear"></div>
    </div>
    <input type="hidden" value="<?php echo isset($id)?'edit':'add'?>"  name="sveAddress">
    </fieldset>
  </form>
</div>
