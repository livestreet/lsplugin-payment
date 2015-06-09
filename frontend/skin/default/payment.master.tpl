<form method="POST" action="https://paymaster.ru/Payment/Init" id="payment-redirect-form">
	<input type="hidden" name="LMI_MERCHANT_ID" value="{$LMI_MERCHANT_ID}">
	<input type="hidden" name="LMI_CURRENCY" value="{$LMI_CURRENCY}">
	<input type="hidden" name="LMI_INVOICE_CONFIRMATION_URL" value="{$LMI_INVOICE_CONFIRMATION_URL}">
	<input type="hidden" name="LMI_PAYMENT_NOTIFICATION_URL" value="{$LMI_PAYMENT_NOTIFICATION_URL}">
	<input type="hidden" name="LMI_FAILURE_URL" value="{$LMI_FAILURE_URL}">

    <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="{$LMI_PAYMENT_AMOUNT}">
    <input type="hidden" name="LMI_PAYMENT_NO" value="{$LMI_PAYMENT_NO}">
    <input type="hidden" name="LMI_PAYMENT_DESC" value="{$LMI_PAYMENT_DESC}">
    <input type="hidden" name="LMI_SIM_MODE" value="{$LMI_SIM_MODE}">
    <input type="hidden" name="LMI_SUCCESS_URL" value="{$LMI_SUCCESS_URL}">
    <input type="hidden" name="key" value="{$key}">
</form>