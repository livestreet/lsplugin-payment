<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp" id="payment-redirect-form">
	<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="{$LMI_PAYMENT_AMOUNT}">
	<input type="hidden" name="LMI_PAYMENT_DESC" value="{$LMI_PAYMENT_DESC}">
	<input type="hidden" name="LMI_PAYMENT_DESC_BASE64" value="{$LMI_PAYMENT_DESC_BASE64}">
	<input type="hidden" name="LMI_PAYMENT_NO" value="{$LMI_PAYMENT_NO}">
	<input type="hidden" name="LMI_PAYEE_PURSE" value="{$LMI_PAYEE_PURSE}">
	<input type="hidden" name="LMI_SIM_MODE" value="{$LMI_SIM_MODE}">
	<input type="hidden" name="LMI_RESULT_URL" value="{$LMI_RESULT_URL}">
	<input type="hidden" name="LMI_SUCCESS_URL" value="{$LMI_SUCCESS_URL}">
	<input type="hidden" name="LMI_SUCCESS_METHOD" value="{$LMI_SUCCESS_METHOD}">
	<input type="hidden" name="LMI_FAIL_URL" value="{$LMI_FAIL_URL}">
	<input type="hidden" name="LMI_FAIL_METHOD" value="{$LMI_FAIL_METHOD}">	
	<input type="hidden" name="key" value="{$key}">
</form>