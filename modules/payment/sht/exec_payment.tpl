<html>
<head>
{literal}
<script language="javascript">
function sht_commit(){
	document.sht_form.submit();
}
</script>
{/literal}
</head>
<body onLoad="sht_commit();" style="text-align:center;">
<img src="{$img_dir}loading.gif"/>
<form action="{$handler}" method="post" id="sht_form" name="sht_form">

	<input type="hidden" name="MerNo" value="{$MerNo}" />
	<input type="hidden" name="BillNo" value="{$BillNo}" />
	<input type="hidden" name="Amount" value="{$Amount}" />
	<input type="hidden" name="Currency" value="{$Currency}" />
	<input type="hidden" name="DisAmount" value="{$DisAmount}" />
	<input type="hidden" name="Language" value="{$Language}" />
	<input type="hidden" name="MD5info" value="{$MD5info}" />
	<input type="hidden" name="ReturnURL" value="{$ReturnURL}" />
	<input type="hidden" name="OrderDesc" value="{$OrderDesc}" />
	<input type="hidden" name="Remark" value="{$Remark}" />
	<input type="hidden" name="FirstName" value="{$FirstName}" />
	<input type="hidden" name="LastName" value="{$LastName}" />
	<input type="hidden" name="MerWebsiet" value="{$MerWebsite}"/>
	<input type="hidden" name="Email" value="{$Email}" />
	<input type="hidden" name="Phone" value="{$Phone}" />
	<input type="hidden" name="ZipCode" value="{$ZipCode}" />
	<input type="hidden" name="Address" value="{$Address}" />
	<input type="hidden" name="City" value="{$City}" />
	<input type="hidden" name="State" value="{$State}" />
	
	<input type="hidden" name="DeliveryFirstName" value="{$DeliveryFirstName}" />
	<input type="hidden" name="DeliveryLastName" value="{$DeliveryLastName}" />
	<input type="hidden" name="DeliveryEmail" value="{$DeliveryEmail}" />
	<input type="hidden" name="DeliveryPhone" value="{$DeliveryPhone}" />
	<input type="hidden" name="DeliveryZipCode" value="{$DeliveryZipCode}" />
	<input type="hidden" name="DeliveryAddress" value="{$DeliveryAddress}" />
	<input type="hidden" name="DeliveryCity" value="{$DeliveryCity}" />
	<input type="hidden" name="DeliveryState" value="{$DeliveryState}" />
	<input type="hidden" name="DeliveryCountry" value="{$DeliveryCountry}" />
	</form>
</body>
</html>