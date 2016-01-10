<div class="container">
	<h3>新用户</h3>
{include file="$tpl_dir./block/errors.tpl"}
{if $step==2}
<ul id="order_step" class="step">
	<li class="done"><span><i>01</i><strong>Summary</strong></span></li>
	<li class="current"><span><i>02</i><strong>Sign in/Login</strong></span></li>
	<li class="todo"><span><i>03</i><strong>Delivery</strong></span></li>
	<li class="todo"><span><i>04</i><strong>Payment</strong></span></li>
</ul>
{/if}
<form id="join-form" action="" method="post" class="form-horizontal">

	<div class="form-group">
	  <label for="email" class="col-sm-2 control-label">邮箱</label>
	  <div class="col-sm-5">
		  <input type="text" class="form-control" name="email" value="{if isset($smarty.post.email)}{$smarty.post.email}{elseif isset($address->email)}{$address->email}{/if}" placeholder="邮箱地址" >
	  </div>
	</div>
	<div class="form-group">
	  <label for="password" class="col-sm-2 control-label">密码</label>
	  <div class="col-sm-5">
			  <input type="password" class="form-control" name="passwd" value="" >
	  </div>
	</div>
	<div class="form-group">
	  <label for="confirmPasswd" class="col-sm-2 control-label">确认密码</label>
	  <div class="col-sm-5">
		  <input type="password" class="form-control" name="confirmPasswd" value="" >
	  </div>
	</div>


	<h3>默认收货地址</h3>
	<div class="form-group">
		  <label for="name" class="col-sm-2 control-label">收货人</label>
		  <div class="col-sm-5">
			  <input type="text" class="form-control" name="name" value="{if isset($smarty.post.name)}{$smarty.post.name}{elseif isset($address->name)}{$address->name}{/if}" placeholder="如.张三">
		  </div>
	 </div>
	<div class="form-group">
	  <label for="address" class="col-sm-2 control-label">地址</label>
	  <div class="col-sm-5">
		  <input type="text" class="form-control" name="address" value="{if isset($smarty.post.address)}{$smarty.post.address}{elseif isset($address->address)}{$address->address}{/if}" placeholder="如.白云区建设路">
	  </div>
	</div>
	<div class="form-group">
	  <label for="address2" class="col-sm-2 control-label">详细地址</label>
	  <div class="col-sm-5">
		  <input type="text" class="form-control" name="address2" value="{if isset($smarty.post.address2)}{$smarty.post.address2}{elseif isset($address->address2)}{$address->address2}{/if}" placeholder="如.2栋3单元">
	  </div>
	</div>
	<div class="form-group">
	  <label for="city" class="col-sm-2 control-label">城市</label>
	  <div class="col-sm-5">
		  <input type="text" class="form-control" name="city" value="{if isset($smarty.post.city)}{$smarty.post.city}{elseif isset($address->city)}{$address->city}{/if}" placeholder="如.北京">
	  </div>
	</div>
	<div class="form-group">
	  <label for="postcode" class="col-sm-2 control-label">邮编</label>
	  <div class="col-sm-5">
		  <input type="text" class="form-control" name="postcode" value="{if isset($smarty.post.postcode)}{$smarty.post.postcode}{elseif isset($address->postcode)}{$address->postcode}{/if}" placeholder="000000">
	  </div>
	</div>
	<div class="form-group" style="display: none;">
	  <label for="postcode" class="col-sm-2 control-label">省份</label>
	  <div class="col-sm-5">
		  <select id="id_state" name="id_state" class="form-control">
		  </select>
	  </div>
	</div>
	<div class="form-group">
	  <label for="postcode" class="col-sm-2 control-label">国家</label>
	  <div class="col-sm-5">
		  <select id="id_country" name="id_country" class="form-control">
			  <option value="">--选择国家--</option>
			  {foreach from=$countrys.items name=country item=country}
				  <option value="{$country.id_country}" {if isset($smarty.post.id_country)}{if $smarty.post.id_country==$country.id_country}selected="selected"{/if}{else}{if $id_default_country==$country.id_country}selected="selected"{/if}{/if}>{$country.name}</option>
			  {/foreach}
		  </select>
	  </div>
	</div>
	<div class="form-group">
	  <label for="phone" class="col-sm-2 control-label">手机</label>
	  <div class="col-sm-5">
		  <input type="text" class="form-control" name="phone" value="{if isset($smarty.post.phone)}{$smarty.post.phone}{elseif isset($address->phone)}{$address->phone}{/if}" placeholder="+86.">
	  </div>
	</div>
	<div class="form-group">
		<div class="col-sm-5 col-sm-offset-2">
			<input type="submit" name="CreateUser" value="注册" class="btn btn-success" />
		</div>
	</div>
</form>
</div>
<script type="text/javascript">
var ajaxLink = "{$link->getPage('AjaxView')}";
{if isset($smarty.post.id_state)}
var secat_id = {$smarty.post.id_state};
{else}
var secat_id = 0;
{/if}
{literal}
	$(document).ready(function(){
		$('#join-form').bootstrapValidator({
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			fields: {
				email: {
					validators: {
						notEmpty: {
							message: '邮箱地址不能为空'
						},
						remote: {
						 url: ajax_dir,
						 name: 'existsEmail',
						 message: '这个邮箱地址已被注册'
						 },
						emailAddress: {
							message: '这不是一个正确的邮箱地址'
						}
					}
				},
				passwd: {
					validators: {
						notEmpty: {
							message: '密码不能为空'
						},
						stringLength: {
							min: 6,
							max: 30,
							message: '密码必须是6-30位由字母和数字组成'
						}
					}
				},
				confirmPasswd: {
					validators: {
						notEmpty: {
							message: '确认密码不能为空'
						},
						identical: {
							field: 'passwd',
							message: '确认密码与原密码不一致'
						}
					}
				},
				name: {
					validators: {
						notEmpty: {
							message: '收件人不能为空'
						},
					}
				},
				address: {
					validators: {
						notEmpty: {
							message: '地址不能为空'
						},
					}
				},
				city: {
					validators: {
						notEmpty: {
							message: '城市不能为空'
						},
					}
				},
				postcode: {
					validators: {
						notEmpty: {
							message: '邮编不能为空'
						},
					}
				},
				'id_country': {
					validators: {
						notEmpty: {
							message: '请选择收货人所在国家'
						},
					}
				},
				phone: {
					validators: {
						notEmpty: {
							message: '手机号码不能为空'
						},
						regexp: {
							regexp: /(^(\d{3,4}-)?\d{7,8})$|(13[0-9]{9})/,
							message: '这不是一个有效的手机号码'
						},
					}
				},
			}
		})


			ajaxStates ();
			$('#id_country').change(function() {
				ajaxStates ();
				});
			function ajaxStates ()
			{
				$.ajax({
					url: ajaxLink,
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
								$('#id_state option[value='+secat_id+']').attr("selected", "selected");
							}
						}
					}); 	
			  }; 
		}); 
{/literal}
</script>