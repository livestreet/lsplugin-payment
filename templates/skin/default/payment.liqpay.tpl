<form method="POST" action="https://liqpay.com/?do=clickNbuy" id="payment-redirect-form">
	<input type="hidden" name="operation_xml" value="{$LIQPAY_OPERATION_XML}">
	<input type="hidden" name="signature" value="{$LIQPAY_SIGNATURE}">	
</form>