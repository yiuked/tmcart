<div class="container" >
{if $referer}
<div class="back-arrow"><i class="icon-arrow-left"></i><strong><a href="{$link->getPage($referer)}" title="返回">返回</a></strong></div>
{/if}
{include file="$tpl_dir./block/errors.tpl"}
<div class="box-style">
	<h2>收货地址</h2>
	<form method="post" action="{$link->getPage('AddressView')}" class="form-horizontal">
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">收货人</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="name" value="{if isset($smarty.post.name)}{$smarty.post.name}{elseif isset($address->name)}{$address->name}{/if}" placeholder="收货人">
			</div>
		</div>
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">地址</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="address" value="{if isset($smarty.post.address)}{$smarty.post.address}{elseif isset($address->address)}{$address->address}{/if}" placeholder="地址">
			</div>
		</div>
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">详细地址</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="address2" value="{if isset($smarty.post.address2)}{$smarty.post.address2}{elseif isset($address->address2)}{$address->address2}{/if}" placeholder="详细地址">
			</div>
		</div>
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">城市</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="city" value="{if isset($smarty.post.city)}{$smarty.post.city}{elseif isset($address->city)}{$address->city}{/if}" placeholder="城市">
			</div>
		</div>
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">邮编</label>
			<div class="col-sm-2">
				<input type="text" class="form-control" name="postcode" value="{if isset($smarty.post.postcode)}{$smarty.post.postcode}{elseif isset($address->postcode)}{$address->postcode}{/if}" placeholder="邮编">
			</div>
		</div>
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">联系电话</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="phone" value="{if isset($smarty.post.phone)}{$smarty.post.phone}{elseif isset($address->phone)}{$address->phone}{/if}" placeholder="联系电话">
			</div>
		</div>
		<div class="form-group" id="contains_states" style="display: none;">
			<label for="name" class="col-sm-2 control-label">省份</label>
			<div class="col-sm-4">
				<select id="id_state" name="id_state" class="form-control"></select>
			</div>
		</div>
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">国家</label>
			<div class="col-sm-4">
				<select id="id_country" name="id_country" class="form-control">
					<option value="NULL">--choose--</option>
					{foreach from=$countrys.items name=country item=country}
						<option value="{$country.id_country}" {if isset($smarty.post.id_country)}{if $smarty.post.id_country==$country.id_country}selected="selected"{/if}{else}{if isset($address) && $address->join('Country', 'id_country')->id == $country.id_country}selected="selected"{/if}{/if}>{$country.name}</option>
					{/foreach}
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-4 col-sm-offset-2">
				<input type="hidden" value="{if isset($address->id)}{$address->id}{/if}" name="id" />
				{if $referer}
				<input type="hidden" value="{$referer}" name="referer" />
				{/if}
				<button type="submit" class="btn btn-success" name="saveAddress"><span class="glyphicon glyphicon-save"></span> 保存</button>
			</div>
		</div>
	</form>
</div>
</div>
<script type="text/javascript">
var ajaxLink = "{$link->getPage('AjaxView')}";
{if isset($address) && $address->join('Country', 'id_country')->need_state}
var secat_id = {$address->join('State', 'id_state')->id};
{else}
var secat_id = 0;
{/if}
{literal}
	$(document).ready(function(){
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