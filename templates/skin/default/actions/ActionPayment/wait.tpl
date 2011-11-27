{assign var="noSidebar" value=true}
{include file='header.tpl'}

	<div class="payment_content">
		<h2>{$aLang.plugin.payment_wait}</h2>
		{$aLang.plugin.payment_wait_notice}
			
		{if $oPayment}
			<br/> {$aLang.plugin.payment_number}: <b>{$oPayment->getId()}</b>
		{/if}
	</div>
	
{include file='footer.tpl'}