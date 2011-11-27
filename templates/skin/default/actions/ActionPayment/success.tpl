{assign var="noSidebar" value=true}
{include file='header.tpl'}

	<div class="topic">
		<div class="content">
			<h2>{$aLang.plugin.payment_success}</h2>
			
			
			{if $oPayment}
				<br/> {$aLang.plugin.payment_number}: <b>{$oPayment->getId()}</b>
			{/if}
		</div>
	</div>

{include file='footer.tpl'}