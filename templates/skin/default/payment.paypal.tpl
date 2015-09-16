<form method="POST" action="https://www.paypal.com/cgi-bin/websc" id="payment-redirect-form">
	<input type="hidden" name="cmd" value="_xclick">
	<input type="hidden" name="no_shipping" value="1">
	<input type="hidden" name="business" value="{$business}">
	<input type="hidden" name="charset" value="utf-8">

	<input id="paypalItemName" type="hidden" name="item_name" value="{$item_name}">
	<input id="paypalQuantity" type="hidden" name="quantity" value="1">
	<input id="paypalAmmount" type="hidden" name="amount" value="{$amount}">

	<input type="hidden" name="currency_code" value="{$currency_code}">
	<input type="hidden" name="lc" value="{$locale}">
	<input type="hidden" name="return" value="{$return}">
	<input type="hidden" name="cancel_return" value="{$cancel_return}">
	<input type="hidden" name="notify_url" value="{$notify_url}">
	<input type="hidden" name="rm" value="2">

	<input type="hidden" name="custom" value="{$customData|escape:'html'}">
</form>