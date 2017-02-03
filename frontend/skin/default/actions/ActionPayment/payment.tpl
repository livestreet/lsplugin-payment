{extends file='layouts/layout.base.tpl'}

{block name='layout_options' prepend}
	{$layoutNoSidebar = true}
{/block}


{block name='layout_content'}
	<div class="payment_content">

		<div class="payment-block" id="payment-area">
			<b>{$aLang.plugin.payment.payment_target_name}:</b> {$oPaymentTarget->getTargetName()}<br />
			<b>{$aLang.plugin.payment.payment_sum}:</b> {$oPayment->getSum()} {$oPayment->getCurrencyName()}<br />

			<br /><br />
			<b>{$aLang.plugin.payment.payment_type_select}:</b><br /><br />

			{if in_array(PluginPayment_ModulePayment::PAYMENT_TYPE_WM,$aPaymentTypeAvailable)}
				<input type="radio" name="payment-type" value="wm" id="payment-type-wm" checked class="input-radio" /> <label for="payment-type-wm"><img src="{$aTemplateWebPathPlugin.payment}images/webmoney.png" alt="Webmoney" title="Webmoney" /></label>
				<br /><br />
			{/if}

			{if in_array(PluginPayment_ModulePayment::PAYMENT_TYPE_LIQPAY,$aPaymentTypeAvailable)}
				<input type="radio" name="payment-type" value="liqpay" id="payment-type-liqpay" class="input-radio" /> <label for="payment-type-liqpay"><img src="{$aTemplateWebPathPlugin.payment}images/liqpay.png" alt="LiqPay (VISA, MASTERCARD)" title="LiqPay (VISA, MASTERCARD)" /></label>
				<br /><br />
			{/if}

			{if in_array(PluginPayment_ModulePayment::PAYMENT_TYPE_ROBOX,$aPaymentTypeAvailable)}
				<input type="radio" name="payment-type" value="robox" id="payment-type-robox" class="input-radio" /> <label for="payment-type-robox"><img src="{$aTemplateWebPathPlugin.payment}images/yandex.png" alt="Яндекс.Деньги" title="Яндекс.Деньги" /></label>
				<br /><br />
			{/if}

			{if in_array(PluginPayment_ModulePayment::PAYMENT_TYPE_W1,$aPaymentTypeAvailable)}
				<input type="radio" name="payment-type" value="w1" id="payment-type-w1" class="input-radio" /> <label for="payment-type-w1"><img src="{$aTemplateWebPathPlugin.payment}images/w1.png" alt="Единый кошелек" title="Единый кошелек" /></label>
				<br /><br />
			{/if}

			{if in_array(PluginPayment_ModulePayment::PAYMENT_TYPE_PAYPRO,$aPaymentTypeAvailable)}
				<input type="radio" name="payment-type" value="paypro" id="payment-type-paypro" class="input-radio" /> <label for="payment-type-paypro"><img src="{$aTemplateWebPathPlugin.payment}images/paypal.png" alt="PayPal" title="PayPal" /></label>
				<br /><br />
			{/if}

			{if in_array(PluginPayment_ModulePayment::PAYMENT_TYPE_MASTER,$aPaymentTypeAvailable)}
				<input type="radio" name="payment-type" value="master" id="payment-type-master" checked class="input-radio" /> <label for="payment-type-master">PayMaster</label>
				<br /><br />
			{/if}

			<input type="hidden" id="payment_id" value="{$oPayment->getId()}">
			<input type="submit" class="ls-button" name="" value="{$aLang.plugin.payment.payment_submit}" onclick="ls.plugin.payment.processing();">
		</div>


		<div id="payment-redirect" style="display: none">
			<div class="post" style="text-align:center;">
				<br>
				{$aLang.plugin.payment.payment_submit_wait_redirect}<br>
				<img src="{$aTemplateWebPathPlugin.payment}images/loader.gif" title="Please wait.." alt="Please wait.." width="31" height="31"/>
			</div>

			<div id="payment-redirect-form-area"></div>
		</div>

	</div>
{/block}