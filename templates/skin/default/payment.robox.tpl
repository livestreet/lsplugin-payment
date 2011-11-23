<form method="POST" action="https://merchant.roboxchange.com/Index.aspx" id="payment-redirect-form">
	<input type="hidden" name="MrchLogin" value="{$MrchLogin}">
	<input type="hidden" name="OutSum" value="{$OutSum}">
	<input type="hidden" name="InvId" value="{$InvId}">
	<input type="hidden" name="Desc" value="{$Desc}">
	<input type="hidden" name="SignatureValue" value="{$SignatureValue}">
	<input type="hidden" name="IncCurrLabel" value="{$IncCurrLabel}">
	<input type="hidden" name="shp_key" value="{$shp_key}">
</form>