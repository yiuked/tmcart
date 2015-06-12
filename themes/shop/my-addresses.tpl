<div id="main_columns_two" class="custom">
<h2>My Addresses</h2>
<fieldset id="p-address">
<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td style="padding:5px;">
		{if $address}
		<p class="addressItme">
			<strong>{$address->first_name} {$address->last_name}</strong><br>
			{$address->address}<br>
			{$address->address2}<br>
			{$address->postcode} {$address->city} {if $address->country->need_state} {$address->state->name}{/if} <br>
			{$address->country->name}<br>
			{$address->phone}<br>
			<a href="{$link->getPage('AddressView')}?id_address={$address->id}" class="all"><strong>Change address</strong></a>
		</p>
		{else}
		<a href="{$link->getPage('AddressView')}" class="all"><strong>Add address</strong></a>
		{/if}
		</td>
	</tr>
</table>
</fieldset>
<br/>
</div>
