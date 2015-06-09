<form method="POST" action="https://merchant.w1.ru/checkout/default.aspx" accept-charset="UTF-8" id="payment-redirect-form">
    <input type="hidden" name="WMI_MERCHANT_ID"    value="{$WMI_MERCHANT_ID}"/>
    <input type="hidden" name="WMI_PAYMENT_AMOUNT" value="{$WMI_PAYMENT_AMOUNT}"/>
    <input type="hidden" name="WMI_CURRENCY_ID"    value="{$WMI_CURRENCY_ID}"/>
    <input type="hidden" name="WMI_PAYMENT_NO"     value="{$WMI_PAYMENT_NO}"/>
    <input type="hidden" name="WMI_SIGNATURE"      value="{$WMI_SIGNATURE}"/>
    <input type="hidden" name="WMI_DESCRIPTION"    value="{$WMI_DESCRIPTION}"/>
    <input type="hidden" name="WMI_SUCCESS_URL"    value="{$WMI_SUCCESS_URL}"/>
    <input type="hidden" name="WMI_FAIL_URL"       value="{$WMI_FAIL_URL}"/>
    <input type="hidden" name="key"  value="{$key}">
</form>