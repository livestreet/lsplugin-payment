{extends file='layouts/layout.base.tpl'}

{block name='layout_options' prepend}
	{$layoutNoSidebar = true}
{/block}


{block name='layout_content'}

	<div class="payment_content">
		<h2>{$aLang.plugin.payment.payment_wait}</h2>
		{$aLang.plugin.payment.payment_wait_notice}
			
		{if $oPayment}
			<br/> {$aLang.plugin.payment.payment_number}: <b>{$oPayment->getId()}</b>
		{/if}
	</div>
	
{/block}