<form method="GET" action="https://secure.payproglobal.com/OrderPage.aspx" id="payment-redirect-form">
	<input type="hidden" name="products" value="{$PAYPRO_PRODUCTS}">
	<input type="hidden" name="hash" value="{$PAYPRO_HASH}">	
	<input type="hidden" name="CustomField1" value="{$PAYPRO_CUSTOMFIELD1}">
</form>